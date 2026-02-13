// Editar contrato
function editContract(contractId) {
    const contract = (window.contractsList || []).find(c => c.id == contractId);
    if (!contract) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se encontró el contrato.'
        });
        return;
    }
    let html = `<div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Número de Contrato</label>
                    <input type="text" class="form-control" value="${contract.contract_number}" readonly>
                </div>
                <div class="form-group">
                    <label>Cliente</label>
                    <input type="text" class="form-control" value="${contract.customer_id}" readonly>
                </div>
                <div class="form-group">
                    <label>Lote</label>
                    <input type="text" class="form-control" value="${contract.lot_id}" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Meses de Financiamiento</label>
                    <input type="text" class="form-control" value="${contract.financing_months}" readonly>
                </div>
                <div class="form-group">
                    <label>Estado</label>
                    <input type="text" class="form-control" value="${contract.status}" readonly>
                </div>
            </div>
        </div>
    </div>`;
    document.getElementById('editContractContent').innerHTML = html;
    $('#editContractModal').modal('show');
}
