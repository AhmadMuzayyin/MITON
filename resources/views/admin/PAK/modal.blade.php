<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pak.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col">
                            <label for="sebelum">SEBELUM PAK</label>
                            <input type="date" class="form-control" id="sebelum" name="sebelum" required>
                        </div>
                        <div class="col mt-2">
                            <label for="sesudah">SESUDAH PAK</label>
                            <input type="date" class="form-control" id="sesudah" name="sesudah" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" role="button" data-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn btn-primary" role="button">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>
