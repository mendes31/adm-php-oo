function confirmDeletion(event, id){

    event.preventDefault();

    Swal.fire({
        title: "Tem certeza que deseja excluir esse registro?",
        text: "Você não poderá reverter esta ação!",
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: "#0d6efd",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Sim, excluir!"
      }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`formDelete${id}`).submit();
        }
      });

}