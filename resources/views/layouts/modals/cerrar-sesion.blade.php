<!-- Logout Modal-->

<div class="modal fade" id="logoutModal" data-bs-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="logoutModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-warning shadow">
                <h5 class="modal-title text-white font-weight-bold" id="logoutModal">¿Listo para salir?</h5>
                <button type="button" class="close text-white font-weight-bold" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Para salir del sistema presiona <strong>SI</strong>.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">NO</button>
                {{-- <a class="btn btn-primary" href="login.html">SI</a> --}}
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">SI</button>
                </form>
            </div>
        </div>
    </div>
</div>
