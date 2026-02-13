function view(customer_id){    
     var url = 'dashboard/calificados/ver/'+ customer_id;
     location.href = site+url;   
}
function cancel(){
	var url= 'dashboard/calificados';
	location.href = site+url;
}

function exportToExcel(califications) {
     const data = califications
     const workbook = XLSX.utils.book_new();
     const worksheet = XLSX.utils.json_to_sheet(data);
     XLSX.utils.book_append_sheet(workbook, worksheet, "Listado de Calificados");
     XLSX.utils.sheet_add_aoa(worksheet, [["ID", "CLIENTE ID", "NOMBRE", "APELLIDO", "USUARIO", "TOTAL VIAJE", "TOTAL CARRO"]], { origin: "A1" });
     XLSX.writeFile(workbook, "calificados.xlsx", { compression: true });
 }