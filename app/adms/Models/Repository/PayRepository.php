<?php

namespace App\adms\Models\Repository;

use App\adms\Helpers\GenerateLog;
use App\adms\Models\Services\DbConnection;
use Exception;
use PDO;

/**
 * Repository responsável por pagar/baixar Contas a Pagar no Banco de dados.
 *
 * Esta classe fornece métodos para criar parcelas e deletar Conta original no banco de dados.
 * Ela estende a classe `DbConnection` para gerenciar conexões com o banco de dados e utiliza o `GenerateLog`
 * para registrar erros que ocorrem durante as operações.
 *
 * @package App\adms\Models\Repository
 * @author Rafael Mendes
 */
class PayRepository extends DbConnection
{

    /**
     * Recupera uma Conta a Pagar específica pelo ID.
     *
     * @param int $id ID da Conta a Pagar.
     * @return array|bool Dados da Conta a Pagar ou `false` se não encontrada.
     */
    public function getPay(int $id): array|bool
    {


        $sql = 'SELECT 
                        ap.id AS id_pay, ap.num_doc, ap.description, ap.file, ap.paid, ap.value, ap.original_value, ap.amount_paid, ap.doc_date, 
                        ap.due_date, ap.expected_date, ap.pay_date, ap.created_at, ap.updated_at,
                        sup.card_name, 
                        au.name AS name_user,
                        au2.name AS user_pay, 
                        af.name AS name_freq, af.id as id_freq, af.days,
                        ab.bank_name, ab.id as id_bank,
                        acc.name AS name_cc, acc.id as id_cc,
                        apm.name AS name_apm, apm.id as id_pm,
                        aap.name AS name_aap, aap.id as id_aap
                FROM adms_pay ap 
                    LEFT JOIN adms_users au ON au.id = ap.user_launch_id
                    LEFT JOIN adms_users au2 ON au2.id = ap.user_pay_id
                    LEFT JOIN adms_frequency af on af.id = ap.frequency_id
                    LEFT JOIN adms_supplier sup on sup.id = ap.partner_id
                    LEFT JOIN adms_bank_accounts ab on ab.id = ap.bank_id
                    LEFT JOIN adms_cost_center acc on acc.id = ap.cost_center_id
                    LEFT JOIN adms_payment_method apm on apm.id = ap.pay_method_id
                    LEFT JOIN adms_accounts_plan aap on aap.id = ap.account_id
                WHERE ap.id = :id LIMIT 1';

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPayIds(int $id): array
    {

        $sql = 'SELECT *
                FROM adms_pay ap
                WHERE ap.id = :id LIMIT 1';

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cadastra uma nova Conta a Pagar.
     *
     * @param array $data Dados da Conta a Pagar a ser cadastrada.
     * @return bool|int ID da Conta cadastrada ou `false` em caso de erro.
     */
    public function createPay(array $dataForm, array $data,  $nova_num_doc, $novo_vencimento, $novo_valor): bool|int
    {
        $name = $this->getSupplierName($data['0']['partner_id']);


        try {
            $sql = 'INSERT INTO adms_pay (description, num_doc, partner_id, bank_id, cost_center_id, 
                    user_launch_id, frequency_id, pay_method_id, account_id, value, original_value,
                    total_value_old, subtotal, amount_paid, discount_value, fine_value, interest, residual_total, 
                    doc_date, due_date, expected_date, created_at)
                    VALUES (:description, :num_doc, :partner_id, :bank_id, :cost_center_id, 
                    :user_launch_id, :frequency_id, :pay_method_id, :account_id, :value, :original_value,
                    :total_value_old, :subtotal, :amount_paid, :discount_value, :fine_value, :interest, :residual_total, 
                    :doc_date, :due_date, :expected_date, :created_at)';

            $stmt = $this->getConnection()->prepare($sql);

            $description = !empty($data['description']) ? $data['description'] : $name;
            $stmt->bindValue(':description', $description, PDO::PARAM_STR);

            $stmt->bindValue(':num_doc',  $nova_num_doc, PDO::PARAM_STR);

            $stmt->bindValue(':partner_id', $data['0']['partner_id'] ?? null, PDO::PARAM_INT);
            $stmt->bindValue(':bank_id', $data['0']['bank_id'] ?? null, PDO::PARAM_INT);
            $stmt->bindValue(':cost_center_id', $data['0']['cost_center_id'] ?? null, PDO::PARAM_INT);
            $stmt->bindValue(':user_launch_id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':frequency_id', $dataForm['form']['frequency_id'] ?? null, PDO::PARAM_INT);
            $stmt->bindValue(':pay_method_id', $data['0']['pay_method_id'] ?? null, PDO::PARAM_INT);
            $stmt->bindValue(':account_id', $data['0']['account_id'] ?? null, PDO::PARAM_INT);

            // $value = number_format((float) $data['value'], 2, '.', '');
            // $stmt->bindParam(':value', $value, PDO::PARAM_STR);
            $value = isset($data['value']) ? str_replace(',', '.', $data['value']) : '0.00';
            $value = number_format((float) $novo_valor, 2, '.', '');
            $stmt->bindParam(':value', $novo_valor, PDO::PARAM_STR);

            // $value = number_format((float) $data['value'], 2, '.', '');
            $stmt->bindParam(':original_value', $novo_valor, PDO::PARAM_STR);

            $total_value_old = isset($data['total_value_old']) ? (float) $data['total_value_old'] : 0.00;
            $total_value_old = number_format($total_value_old, 2, '.', '');
            $stmt->bindParam(':total_value_old', $total_value_old, PDO::PARAM_STR);

            $subtotal = isset($data['subtotal']) ? (float) $data['subtotal'] : 0.00;
            $subtotal = number_format($subtotal, 2, '.', '');
            $stmt->bindParam(':subtotal', $subtotal, PDO::PARAM_STR);

            $amount_paid = isset($data['amount_paid']) ? (float) $data['amount_paid'] : 0.00;
            $amount_paid = number_format($amount_paid, 2, '.', '');
            $stmt->bindParam(':amount_paid', $amount_paid, PDO::PARAM_STR);

            $discount_value = isset($data['discount_value']) ? (float) $data['discount_value'] : 0.00;
            $discount_value = number_format($discount_value, 2, '.', '');
            $stmt->bindParam(':discount_value', $discount_value, PDO::PARAM_STR);

            $fine_value = isset($data['fine_value']) ? (float) $data['fine_value'] : 0.00;
            $fine_value = number_format($fine_value, 2, '.', '');
            $stmt->bindParam(':fine_value', $fine_value, PDO::PARAM_STR);

            $interest = isset($data['interest']) ? (float) $data['interest'] : 0.00;
            $interest = number_format($interest, 2, '.', '');
            $stmt->bindParam(':interest', $interest, PDO::PARAM_STR);

            $residual_total = isset($data['residual_total']) ? (float) $data['residual_total'] : 0.00;
            $residual_total = number_format($residual_total, 2, '.', '');
            $stmt->bindParam(':residual_total', $residual_total, PDO::PARAM_STR);

            $stmt->bindValue(':doc_date', date("Y-m-d H:i:s"));
            $stmt->bindValue(':due_date', $novo_vencimento ? date("Y-m-d H:i:s", strtotime($novo_vencimento)) : null, PDO::PARAM_STR);
            $stmt->bindValue(':expected_date', $novo_vencimento ? date("Y-m-d H:i:s", strtotime($novo_vencimento)) : null, PDO::PARAM_STR);
            $stmt->bindValue(':created_at', date("Y-m-d H:i:s"));

            $stmt->execute();

            return $this->getConnection()->lastInsertId();
        } catch (Exception $e) {
            GenerateLog::generateLog("error", "Conta não cadastrada.", ['description' => $data['0']['description'], 'error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Atualizar os dados de uma Conta existente.
     *
     * Este método atualiza as informações de um Conta existente. Se a senha for fornecida, ela também será atualizada.
     * Em caso de erro, um log é gerado.
     *
     * @param array $data Dados atualizados do Conta, incluindo `id`, `name`.
     * @return bool `true` se a atualização foi bem-sucedida ou `false` em caso de erro.
     */
    public function updatePay(array $dataForm, array $data): bool

    {
        var_dump($data);
        var_dump($dataForm);

        try {
            $sql = 'UPDATE adms_pay 
                    SET bank_id = :bank_id, 
                        pay_method_id = :pay_method_id, 
                        value = :value,
                        amount_paid = :amount_paid,
                        discount_value = :discount_value, 
                        fine_value = :fine_value, 
                        interest = :interest, 
                        user_pay_id = :user_pay_id,
                        paid = 1,
                        pay_date = :pay_date,
                        updated_at = :updated_at';

            // Condição para indicar qual registro editar
            $sql .= ' WHERE id = :id_pay';

            var_dump($sql);

            // Preparar a QUERY
            $stmt = $this->getConnection()->prepare($sql);

            $stmt->bindValue(':bank_id', $data['bank_id'] ?? null, PDO::PARAM_INT);
            $stmt->bindValue(':pay_method_id', $data['pay_method_id'] ?? null, PDO::PARAM_INT);

            $subtotal = isset($data['subtotal']) ? str_replace(',', '.', $data['subtotal']) : '0.00';
            $subtotal = number_format((float) $subtotal, 2, '.', '');
            $stmt->bindParam(':value', $subtotal, PDO::PARAM_STR);

            $amountPaid = $subtotal + $dataForm['amount_paid'];
            $amountPaid = number_format((float) $amountPaid, 2, '.', '');
            $stmt->bindParam(':amount_paid',$amountPaid, PDO::PARAM_STR);

            $discount_value = isset($data['discount_value']) ? (float) $data['discount_value'] : 0.00;
            $discount_value = number_format($discount_value, 2, '.', '');
            $stmt->bindParam(':discount_value', $discount_value, PDO::PARAM_STR);

            $fine_value = isset($data['fine_value']) ? (float) $data['fine_value'] : 0.00;
            $fine_value = number_format($fine_value, 2, '.', '');
            $stmt->bindParam(':fine_value', $fine_value, PDO::PARAM_STR);

            $interest = isset($data['interest']) ? (float) $data['interest'] : 0.00;
            $interest = number_format($interest, 2, '.', '');
            $stmt->bindParam(':interest', $interest, PDO::PARAM_STR);

            $stmt->bindValue(':user_pay_id',  $_SESSION['user_id'], PDO::PARAM_INT);

            // $stmt->bindValue(':doc_date', date("Y-m-d H:i:s"));
            $stmt->bindValue(':pay_date', date("Y-m-d H:i:s"));
            $stmt->bindValue(':updated_at', date("Y-m-d H:i:s"));
            $stmt->bindValue(':id_pay', $data['id_pay'], PDO::PARAM_INT);

            return $stmt->execute();
        } catch (Exception $e) {
            // Gerar log de erro
            GenerateLog::generateLog("error", "Conta não baixada.", ['id' => $data['id_pay'], 'error' => $e->getMessage()]);

            return false;
        }
    }

    /**
     * Atualizar os dados de uma Conta existente.
     *
     * Este método atualiza as informações de um Conta existente. Se a senha for fornecida, ela também será atualizada.
     * Em caso de erro, um log é gerado.
     *
     * @param array $data Dados atualizados do Conta, incluindo `id`, `name`.
     * @return bool `true` se a atualização foi bem-sucedida ou `false` em caso de erro.
     */
    public function updatePayResidue(array $dataBD, array $data): bool

    {

        try {
            $sql = 'UPDATE adms_pay 
                    SET num_doc = :num_doc,
                        bank_id = :bank_id, 
                        pay_method_id = :pay_method_id, 
                        value = :value,
                        amount_paid = :amount_paid, 
                        discount_value = :discount_value, 
                        fine_value = :fine_value, 
                        interest = :interest, 
                        user_pay_id = :user_pay_id,
                        pay_date = :pay_date,
                        updated_at = :updated_at';

            // Condição para indicar qual registro editar
            $sql .= ' WHERE id = :id_pay';

            // var_dump($sql);       
            // var_dump($data);

            // Preparar a QUERY
            $stmt = $this->getConnection()->prepare($sql);

            // 'description' => "Doc: ". "{$this->data['form']['num_doc']} " ." - " . "{$this->dataBD['card_name']}" . " (Parcelamento)",

            $num_doc = "(Resíduo) " . $data['num_doc'];
            $stmt->bindValue(':num_doc', $num_doc, PDO::PARAM_STR);

            $stmt->bindValue(':bank_id', $data['bank_id'] ?? null, PDO::PARAM_INT);
            $stmt->bindValue(':pay_method_id', $data['pay_method_id'] ?? null, PDO::PARAM_INT);

            //formata valor subtotal do formulário e guarda na variável $subtotal
            $subtotal = str_replace(',', '.', $data['subtotal']);
            $subtotal = number_format((float) $subtotal, 2, '.', '');
            //formata valor original_value do formulário e guarda na variável $original_value
            $original_value = str_replace(',', '.', $dataBD['value']);
            $original_value = number_format((float) $original_value, 2, '.', '');
            // Subtrair os valores corretamente formatados
            $original_value = $original_value - $subtotal;

            // var_dump($original_value);
            // exit;

            //value = recebe original_value
            $stmt->bindParam(':value', $original_value, PDO::PARAM_STR);

            $stmt->bindParam(':amount_paid', $original_value, PDO::PARAM_STR);

            $amountPaid = $subtotal + $dataBD['amount_paid'];
            $amountPaid = number_format((float) $amountPaid, 2, '.', '');
            $stmt->bindParam(':amount_paid',$amountPaid, PDO::PARAM_STR);


            $discount_value = isset($data['discount_value']) ? (float) $data['discount_value'] : 0.00;
            $discount_value = number_format($discount_value, 2, '.', '');
            $stmt->bindParam(':discount_value', $discount_value, PDO::PARAM_STR);

            $fine_value = isset($data['fine_value']) ? (float) $data['fine_value'] : 0.00;
            $fine_value = number_format($fine_value, 2, '.', '');
            $stmt->bindParam(':fine_value', $fine_value, PDO::PARAM_STR);

            $interest = isset($data['interest']) ? (float) $data['interest'] : 0.00;
            $interest = number_format($interest, 2, '.', '');
            $stmt->bindParam(':interest', $interest, PDO::PARAM_STR);

            $stmt->bindValue(':user_pay_id', $_SESSION['user_id'], PDO::PARAM_INT);

            // $stmt->bindValue(':doc_date', date("Y-m-d H:i:s"));
            $stmt->bindValue(':pay_date', date("Y-m-d H:i:s"));
            $stmt->bindValue(':updated_at', date("Y-m-d H:i:s"));
            $stmt->bindValue(':id_pay', $data['id_pay'], PDO::PARAM_INT);

            return $stmt->execute();
        } catch (Exception $e) {
            // Gerar log de erro
            GenerateLog::generateLog("error", "Conta não baixada.", ['id' => $data['id_pay'], 'error' => $e->getMessage()]);

            return false;
        }
    }



    /**
     * Cadastra um pagamento parcial.
     *
     * @param array $data Dados de um pagamento parcial.
     * @return bool|int ID da Conta cadastrada ou `false` em caso de erro.
     */
    public function createPartialValue(array $dataForm, array $data): bool|int
    {
        var_dump($data);

        try {
            $sql = 'INSERT INTO adms_partial_value (account_id, type, partial_value, user_id, created_at)
                    VALUES (:account_id, :type, :partial_value, :user_id, :created_at)';

            var_dump($sql);


            $stmt = $this->getConnection()->prepare($sql);

            $stmt->bindValue(':account_id', $data['id_pay'] ?? null, PDO::PARAM_INT);

            $stmt->bindValue(':type', 'Pagar', PDO::PARAM_STR);

            $partial_value = isset($data['value']) ? str_replace(',', '.', $data['value']) : '0.00';
            $partial_value = number_format((float) $partial_value, 2, '.', '');
            $stmt->bindParam(':partial_value', $partial_value, PDO::PARAM_STR);

            $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

            $stmt->bindValue(':created_at', date("Y-m-d H:i:s"));

            $stmt->execute();

            return $this->getConnection()->lastInsertId();
        } catch (Exception $e) {
            GenerateLog::generateLog("error", "Conta não cadastrada.", ['account_id' => $data['account_id'], 'error' => $e->getMessage()]);
            var_dump($e->getMessage());
            return false;
        }
    }

    /**
     * Cadastra um pagamento parcial.
     *
     * @param array $data Dados de um pagamento parcial.
     * @return bool|int ID da Conta cadastrada ou `false` em caso de erro.
     */
    public function createMovement(array $dataForm, array $data): bool|int
    {
        var_dump($data);
        try {
            $sql = 'INSERT INTO adms_movements (type, movement, description, movement_value, user_id, bank_id, method_id, movement_id, created_at)
                    VALUES (:type, :movement,  :description, :movement_value, :user_id,:bank_id, :method_id, :movement_id, :created_at)';

            $stmt = $this->getConnection()->prepare($sql);

            $stmt->bindValue(':type', 'Saída', PDO::PARAM_STR);
            $stmt->bindValue(':movement', 'Conta à Pagar', PDO::PARAM_STR);
            $stmt->bindParam(':description',  $data['description'], PDO::PARAM_STR);

            $movement_value = isset($data['subtotal']) ? str_replace(',', '.', $data['subtotal']) : '0.00';
            $movement_value = number_format((float) $movement_value, 2, '.', '');
            $stmt->bindParam(':movement_value', $movement_value, PDO::PARAM_STR);

            $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':bank_id', $data['bank_id'], PDO::PARAM_INT);
            $stmt->bindValue(':method_id', $data['pay_method_id'], PDO::PARAM_INT);
            $stmt->bindValue(':movement_id', $data['id_pay'] ?? null, PDO::PARAM_INT);

            $stmt->bindValue(':created_at', date("Y-m-d H:i:s"));

            $stmt->execute();

            return $this->getConnection()->lastInsertId();
        } catch (Exception $e) {
            GenerateLog::generateLog("error", "Conta não cadastrada.", ['movement_id' => $data['movement_id'], 'error' => $e->getMessage()]);
            return false;
        }
    }



    /**
     * Deleta a Conta a Pagar original pelo ID.
     *
     * @param int $id ID da Conta a Pagar a ser deletada.
     * @return bool `true` se deletado com sucesso ou `false` em caso de erro.
     */
    public function deletePay(int $id): bool
    {
        try {
            $sql = 'DELETE FROM adms_pay WHERE id = :id LIMIT 1';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            GenerateLog::generateLog("error", "Erro ao deletar conta.", ['id' => $id, 'error' => $e->getMessage()]);
            return false;
        }
    }

    public function getSupplierName(int $partner_id): string
    {

        $sql = "SELECT 	card_name FROM adms_supplier WHERE id = :partner_id LIMIT 1";

        $stmt = $this->getConnection()->prepare($sql);

        $stmt->bindParam(':partner_id', $partner_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function getSupplierNameAccount(int $id): string
    {

        $sql = "SELECT as2.card_name from adms_pay ap 
                INNER JOIN adms_supplier as2 on as2.id = ap.partner_id 
                WHERE ap.id = :id LIMIT 1";

        $stmt = $this->getConnection()->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function existsNumDocForPartner($numDoc, $partnerId, $ignoreId = null)
    {


        $sql = "SELECT COUNT(*) FROM adms_pay WHERE num_doc = :num_doc AND partner_id = :partner_id";


        if ($ignoreId) {
            $sql .= " AND id != :ignore_id"; // Ignorar o próprio ID
        }

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':num_doc', $numDoc);
        $stmt->bindParam(':partner_id', $partnerId);

        if ($ignoreId) {
            $stmt->bindParam(':ignore_id', $ignoreId);
        }

        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
