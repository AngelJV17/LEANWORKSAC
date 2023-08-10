<!-- Aperturar Caja -->
<div class="modal fade" id="formCaja" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-muted font-weight-bold" id="exampleModalLongTitle">¿Estas seguro de aperturar una caja?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('control-cajas') }}" method="POST">
                @csrf

                <div class="modal-body text-center">
                    <h6 class="text-muted">Si es asi, a continuación presione <strong>APERTURAR</strong>.</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary text-uppercase"
                        data-dismiss="modal">CANCELAR</button>
                    <button type="submit" class="btn btn-primary text-uppercase">APERTURAR</button>
                </div>
            </form>
        </div>
    </div>
</div>
