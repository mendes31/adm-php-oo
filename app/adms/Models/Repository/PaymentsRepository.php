<?php

namespace App\adms\Models\Repository;

use App\adms\Helpers\GenerateLog;
use App\adms\Models\Services\DbConnection;
use Exception;
use PDO;

/**
 * Repository responsável em buscar e manipular Contas à pagar no banco de dados.
 *
 * Esta classe fornece métodos para recuperar, criar, atualizar e deletar Contas à pagar no banco de dados.
 * Ela estende a classe `DbConnection` para gerenciar conexões com o banco de dados e utiliza o `GenerateLog`
 * para registrar erros que ocorrem durante as operações.
 *
 * @package App\adms\Models\Repository
 * @author Rafael Mendes
 */
class PaymentsRepository extends DbConnection
{

    /**
     * Recuperar todos os Contas à pagar com paginação.
     *
     * Este método retorna uma lista de Contas à pagar da tabela `adms_pay`, com suporte à paginação.
     *
     * @param int $page Número da página para recuperação de Contas à pagar (começa do 1).
     * @param int $limitResult Número máximo de resultados por página.
     * @return array Lista de Contas à pagar recuperados do banco de dados.
     */
    public function getAllPayments(int $page = 1, int $limitResult = 10): array
    {
        // Calcular o registro inicial, função max para garantir valor mínimo 0
        $offset = max(0, ($page - 1) * $limitResult);

        // QUERY para recuperar os registros do banco de dados
        $sql = 'SELECT 
            id, description, num_doc, file, paid, partner_id, bank_id, cost_center_id,
            user_pay_id,  user_launch_id, frequency_id, pay_method_id,  account_id, value, 
            original_value,  total_value_old, subtotal, amount_paid, discount_value, 
            fine_value,  interest, residual_total, doc_date, due_date, expected_date, pay_date
        FROM adms_pay
        ORDER BY id ASC
        LIMIT :limit OFFSET :offset';

        // Preparar a QUERY
        $stmt = $this->getConnection()->prepare($sql);

        // Substituir os parâmetros da QUERY pelos valores
        $stmt->bindValue(':limit', $limitResult, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        // Executar a QUERY
        $stmt->execute();

        // Ler os registros e retornar
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recuperar a quantidade total de Contas à pagar para paginação.
     *
     * Este método retorna a quantidade total de Contas à pagar na tabela `adms_bank_accounts`, útil para a paginação.
     *
     * @return int Quantidade total de Contas à pagar encontrados no banco de dados.
     */
    public function getAmountPayments(): int
    {
        // QUERY para recuperar a quantidade de registros
        $sql = 'SELECT COUNT(id) as amount_records
                FROM adms_pay';

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();

        return (int) ($stmt->fetch(PDO::FETCH_ASSOC)['amount_records'] ?? 0);
    }

    /**
     * Recuperar um Banco específico pelo ID.
     *
     * Este método retorna os detalhes de um Banco específico identificado pelo ID.
     *
     * @param int $id ID do Banco a ser recuperado.
     * @return array|bool Detalhes do Banco recuperado ou `false` se não encontrado.
     */
    public function getPay(int $id): array|bool
    {
        // QUERY para recuperar o registro do banco de dados
        $sql = 'SELECT 
            id, description, num_doc, file, paid, partner_id, bank_id, cost_center_id,
            user_pay_id,  user_launch_id, frequency_id, pay_method_id,  account_id, value, 
            original_value,  total_value_old, subtotal, amount_paid, discount_value, 
            fine_value,  interest, residual_total, doc_date, due_date, expected_date, pay_date, created_at, updated_at
        FROM adms_pay
        WHERE id = :id
        ORDER BY id DESC';

        // Preparar a QUERY
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        // Executar a QUERY
        $stmt->execute();

        // Ler o registro e retornar
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cadastrar uma nova Conta à Pagar
     *
     * Este método insere uma nova Conta à Pagar na tabela `adms_pay`. Em caso de erro, um log é gerado.
     *
     * @param array $data Dados do Banco a ser cadastrado, incluindo `name`.
     * @return bool|int `true` se o Banco foi criado com sucesso ou `false` em caso de erro.
     */
    public function createPay(array $data): bool|int
    {
        var_dump($data);
        return false;
    //     try {

    //         // QUERY para cadastrar Banco
    //         $sql = 'INSERT INTO adms_pay 
    //         (description, num_doc, /*file,*/ partner_id, bank_id, cost_center_id, user_launch_id, frequency_id, pay_method_id,  account_id, value, original_value,
    //         total_value_old, subtotal, amount_paid, discount_value, fine_value,  interest, residual_total, doc_date, due_date, expected_date, pay_date, created_at) 
    //         VALUES (:description, :num_doc, :file, :partner_id, :bank_id, :cost_center_id, :user_launch_id, :frequency_id, :pay_method_id, :account_id, :value, :original_value,
    //         :total_value_old, :subtotal, :amount_paid, :discount_value, :fine_value,  :interest, :residual_total, :doc_date, :due_date, :expected_date, :pay_date, :created_at)';

    //         // Preparar a QUERY
    //         $stmt = $this->getConnection()->prepare($sql);

    //         // Substituir os parâmetros da QUERY pelos valores
    //         $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
    //         $stmt->bindValue(':num_doc', $data['num_doc'], PDO::PARAM_STR);

    //         // $stmt->bindValue(':file', $data['file'], PDO::PARAM_STR);

    //         // $stmt->bindValue(':partner_id', $data['partner_id'], PDO::PARAM_INT);
    //         // $stmt->bindValue(':bank_id', $data['bank_id'], PDO::PARAM_INT);
    //         // $stmt->bindValue(':cost_center_id', $data['cost_center_id'], PDO::PARAM_INT);
    //         // $stmt->bindValue(':user_launch_id', $data['user_launch_id'], PDO::PARAM_INT);
    //         // $stmt->bindValue(':frequency_id', $data['frequency_id'], PDO::PARAM_INT);
    //         // $stmt->bindValue(':pay_method_id', $data['pay_method_id'], PDO::PARAM_INT);
    //         // $stmt->bindValue(':account_id', $data['account_id'], PDO::PARAM_INT);

    //         $stmt->bindValue(':partner_id', $data['partner_id'] ?? null, PDO::PARAM_INT);
    //         $stmt->bindValue(':bank_id', $data['bank_id'] ?? null, PDO::PARAM_INT);
    //         $stmt->bindValue(':cost_center_id', $data['cost_center_id'] ?? null, PDO::PARAM_INT);
    //         $stmt->bindValue(':user_launch_id', $data['user_launch_id'] ?? null, PDO::PARAM_INT);
    //         $stmt->bindValue(':frequency_id', $data['frequency_id'] ?? null, PDO::PARAM_INT);
    //         $stmt->bindValue(':pay_method_id', $data['pay_method_id'] ?? null, PDO::PARAM_INT);
    //         $stmt->bindValue(':account_id', $data['account_id'] ?? null, PDO::PARAM_INT);


    //         // $value = number_format((float) $data['value'], 2, '.', '');
    //         // $stmt->bindParam(':value', $value, PDO::PARAM_STR);

    //         // $value = number_format((float) $data['value'], 2, '.', '');
    //         // $stmt->bindParam(':original_value', $value, PDO::PARAM_STR);

    //         // $total_value_old = number_format((float) $data['total_value_old'], 2, '.', '');
    //         // $stmt->bindParam(':total_value_old', $total_value_old, PDO::PARAM_STR);

    //         // $subtotal = number_format((float) $data['subtotal'], 2, '.', '');
    //         // $stmt->bindParam(':subtotal', $subtotal, PDO::PARAM_STR);

    //         // $amount_paid = number_format((float) $data['amount_paid'], 2, '.', '');
    //         // $stmt->bindParam(':amount_paid', $amount_paid, PDO::PARAM_STR);

    //         // $discount_value = number_format((float) $data['discount_value'], 2, '.', '');
    //         // $stmt->bindParam(':discount_value', $discount_value, PDO::PARAM_STR);

    //         // $fine_value = number_format((float) $data['fine_value'], 2, '.', '');
    //         // $stmt->bindParam(':fine_value', $fine_value, PDO::PARAM_STR);

    //         // $interest = number_format((float) $data['interest'], 2, '.', '');
    //         // $stmt->bindParam(':interest', $interest, PDO::PARAM_STR);

    //         // $residual_total = number_format((float) $data['residual_total'], 2, '.', '');
    //         // $stmt->bindParam(':residual_total', $residual_total, PDO::PARAM_STR);

    //         // Formatando valores numéricos corretamente como strings para evitar erros no banco
    //         $decimalFields = [
    //             'value',
    //             'original_value',
    //             'total_value_old',
    //             'subtotal',
    //             'amount_paid',
    //             'discount_value',
    //             'fine_value',
    //             'interest',
    //             'residual_total'
    //         ];

    //         foreach ($decimalFields as $field) {
    //             $formattedValue = isset($data[$field]) ? number_format((float) $data[$field], 2, '.', '') : '0.00';
    //             $stmt->bindValue(":{$field}", $formattedValue, PDO::PARAM_STR);
    //         }


    //         $stmt->bindValue(':doc_date', date("Y-m-d H:i:s")); // data lançamento data atual

    //         $dueDate = isset($data['due_date']) ? date("Y-m-d H:i:s", strtotime($data['due_date'])) : null;
    //         $stmt->bindValue(':due_date', $dueDate, PDO::PARAM_STR); // data vencimeto deve pegar do formulário

    //         $expectedDate = isset($data['expected_date']) ? date("Y-m-d H:i:s", strtotime($data['expected_date'])) : null;
    //         $stmt->bindValue(':expected_date', $expectedDate, PDO::PARAM_STR); // data previsaõ pagamento deve pegar do formulário

    //         $stmt->bindValue(':created_at', date("Y-m-d H:i:s")); // data criação data atual

    //         //     // Executar a QUERY
    //         $stmt->execute();

    //         //     // Retornar o ID da Conta recém cadastrado
    //         return $this->getConnection()->lastInsertId();
    //     } catch (Exception $e) {
    //         // Gerar log de erro
    //         GenerateLog::generateLog("error", "Conta não cadastrado.", ['name' => $data['partner_id'], 'error' => $e->getMessage()]);

    //         return false;
    //     }
    // }

    // /**
    //  * Atualizar os dados de uma Conta existente.
    //  *
    //  * Este método atualiza as informações de uma Conta existente.
    //  * Em caso de erro, um log é gerado.
    //  *
    //  * @param array $data Dados atualizados de uma Conta.
    //  * @return bool `true` se a atualização foi bem-sucedida ou `false` em caso de erro.
    //  */
    // public function updatePay(array $data): bool
    // {
    //     try {
    //         // QUERY para atualizar Banco
    //         $sql = 'UPDATE adms_pay SET description = :description, num_doc = :num_doc, /*file,*/ partner_id = :partner_id,
    //         bank_id = :bank_id, cost_center_id = :cost_center_id, user_pay_id = :user_pay_id, frequency_id = :frequency_id, pay_method_id = :pay_method_id,  
    //         account_id = :account_id, value = :value, original_value = :original_value, total_value_old = :total_value_old, subtotal = :subtotal,
    //         amount_paid = :amount_paid, discount_value = :discount_value, fine_value = :fine_value,  interest = :interest, residual_total = :residual_total,
    //         doc_date = :doc_date, due_date = :due_date, expected_date = :expected_date, pay_date = :pay_date, updated_at = :updated_at';


    //         // Condição para indicar qual registro editar
    //         $sql .= ' WHERE id = :id';

    //         // Preparar a QUERY
    //         $stmt = $this->getConnection()->prepare($sql);

    //         // Substituir os parâmetros da QUERY pelos valores
    //         $stmt->bindValue(':description', $data['description'] ?? null, PDO::PARAM_STR); //descrição pode ser nula
    //         $stmt->bindValue(':num_doc', $data['num_doc'], PDO::PARAM_STR);                 //nº do documento não pode ser nulo

    //         // Se necessário, descomentar esta linha para incluir arquivos
    //         // $stmt->bindValue(':file', $data['file'] ?? null, PDO::PARAM_STR);

    //         $stmt->bindValue(':partner_id', $data['partner_id'], PDO::PARAM_INT);           //id do fornecedor
    //         $stmt->bindValue(':bank_id', $data['bank_id'], PDO::PARAM_INT);                 //id do banco de saída
    //         $stmt->bindValue(':cost_center_id', $data['cost_center_id'], PDO::PARAM_INT);   //id centro de custo
    //         $stmt->bindValue(':user_pay_id', $data['user_pay_id'], PDO::PARAM_INT);         //id usuário que realizar o pagamento
    //         $stmt->bindValue(':frequency_id', $data['frequency_id'], PDO::PARAM_INT);       //id da frequância ou recorreância
    //         $stmt->bindValue(':pay_method_id', $data['pay_method_id'], PDO::PARAM_INT);     //id da forma de pagamento
    //         $stmt->bindValue(':account_id', $data['account_id'], PDO::PARAM_INT);           //id do plano de contas


    //         $value = number_format((float) $data['value'], 2, '.', '');
    //         $stmt->bindParam(':value', $value, PDO::PARAM_STR);

    //         $value = number_format((float) $data['value'], 2, '.', '');
    //         $stmt->bindParam(':original_value', $value, PDO::PARAM_STR);

    //         $total_value_old = number_format((float) $data['total_value_old'], 2, '.', '');
    //         $stmt->bindParam(':total_value_old', $total_value_old, PDO::PARAM_STR);

    //         $subtotal = number_format((float) $data['subtotal'], 2, '.', '');
    //         $stmt->bindParam(':subtotal', $subtotal, PDO::PARAM_STR);

    //         $amount_paid = number_format((float) $data['amount_paid'], 2, '.', '');
    //         $stmt->bindParam(':amount_paid', $amount_paid, PDO::PARAM_STR);

    //         $discount_value = number_format((float) $data['discount_value'], 2, '.', '');
    //         $stmt->bindParam(':discount_value', $discount_value, PDO::PARAM_STR);

    //         $fine_value = number_format((float) $data['fine_value'], 2, '.', '');
    //         $stmt->bindParam(':fine_value', $fine_value, PDO::PARAM_STR);

    //         $interest = number_format((float) $data['interest'], 2, '.', '');
    //         $stmt->bindParam(':interest', $interest, PDO::PARAM_STR);

    //         $residual_total = number_format((float) $data['residual_total'], 2, '.', '');
    //         $stmt->bindParam(':residual_total', $residual_total, PDO::PARAM_STR);

    //         $stmt->bindValue(':doc_date', date("Y-m-d H:i:s")); // data lançamento data atual

    //         $dueDate = isset($data['due_date']) ? date("Y-m-d H:i:s", strtotime($data['due_date'])) : null;
    //         $stmt->bindValue(':due_date', $dueDate, PDO::PARAM_STR); // data vencimeto deve pegar do formulário

    //         $expectedDate = isset($data['expected_date']) ? date("Y-m-d H:i:s", strtotime($data['expected_date'])) : null;
    //         $stmt->bindValue(':expected_date', $expectedDate, PDO::PARAM_STR); // data previsaõ pagamento deve pegar do formulário

    //         $stmt->bindValue(':updated_at', date("Y-m-d H:i:s")); // data atualização data atual

    //         // Executar a QUERY
    //         return $stmt->execute();
    //     } catch (Exception $e) {
    //         // Gerar log de erro
    //         GenerateLog::generateLog("error", "Conta não editado.", ['id' => $data['id'], 'error' => $e->getMessage()]);

    //         return false;
    //     }
    }

    /**
     * Deletar uam Conta pelo ID.
     *
     * Este método remove uam Conta específico da tabela `adms_pay`. Em caso de erro, um log é gerado.
     *
     * @param int $id ID da COnta a ser deletada.
     * @return bool `true` se a Conta foi deletado com sucesso ou `false` em caso de erro.
     */
    public function deletePay(int $id): bool
    {
        try {
            // QUERY para deletar Conta
            $sql = 'DELETE FROM adms_pay WHERE id = :id LIMIT 1';

            // Preparar a QUERY
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            // Executar a QUERY
            $stmt->execute();

            // Verificar o número de linhas afetadas
            $affectedRows = $stmt->rowCount();

            if ($affectedRows > 0) {
                return true;
            } else {
                // Gerar log de erro
                GenerateLog::generateLog("error", "Conta não apagada.", ['id' => $id]);

                return false;
            }
        } catch (Exception $e) {
            // Gerar log de erro
            GenerateLog::generateLog("error", "Conta não apagada.", ['id' => $id, 'error' => $e->getMessage()]);

            return false;
        }
    }

    public function getAllPaymentsSelect(): array
    {
        // QUERY para recuperar os registros do banco de dados
        $sql = 'SELECT SELECT 
            id, description, num_doc, file, paid, partner_id, bank_id, cost_center_id,
            user_pay_id,  user_launch_id, frequency_id, pay_method_id,  account_id, value, 
            original_value,  total_value_old, subtotal, amount_paid, discount_value, 
            fine_value,  interest, residual_total, doc_date, due_date, expected_date, pay_date
        FROM adms_pay                
        ORDER BY name ASC';

        // Preparar a QUERY
        $stmt = $this->getConnection()->prepare($sql);


        // Executar a QUERY
        $stmt->execute();

        // Ler os registros e retornar
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
