{{-- <!-- Logout Modal-->
<div class="modal fade" id="formCaja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
    </div>
</div>
</div> --}}

<!-- Aperturar Caja -->
<div class="modal fade" id="formCaja" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-muted font-weight-bold" id="exampleModalLongTitle">APERTURAR CAJA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('control-cajas') }}" method="POST">
                @csrf

                <div class="modal-body">
                    <p class="text-muted">Inserta tu <strong>USUARIO</strong> y <strong>CONTRASEÑA</strong> para poder
                        aperturar la caja.</p>

                    <div class="form-group">
                        <label for="username" class="col-form-label text-uppercase">Usuario:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label text-uppercase">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
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
