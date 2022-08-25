document
    .getElementById("delete")
    .addEventListener("click", control)
    function control(e){ 
        if(!confirm("Do you really want to delete this disc ?")){
            e.preventDefault();
        }
    };