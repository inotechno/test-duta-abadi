@extends('layout')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-50">
    <a href="{{route('crud.index') }}" class="btn btn-primary">CRUD TEST</a>
</div>
<div class="d-flex justify-content-center align-items-center vh-50">
    <div class="card m-3">
        <div class="card-body">
            <h5 class="card-title text-center">Anagram Checker</h5>
            <form id="anagram-form">
                @csrf
                <div class="form-group">
                    <label for="str1">Kalimat 1</label>
                    <input type="text" class="form-control" id="str1" name="str1" placeholder="Masukkan kalimat pertama"
                        required>
                </div>
                <div class="form-group">
                    <label for="str2">Kalimat 2</label>
                    <input type="text" class="form-control" id="str2" name="str2" placeholder="Masukkan kalimat kedua"
                        required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Periksa</button>
            </form>
            <div class="mt-3 show-result">
                <p class="text-center">
                    Hasil: <strong id="result"></strong>
                </p>
            </div>
        </div>
    </div>

    <div class="card m-3">
        <div class="card-body">
            <h5 class="card-title text-center">Frequency Letter</h5>
            <form id="frequency-form">
                @csrf
                <div class="form-group">
                    <label for="sentence">Kalimat</label>
                    <input type="text" class="form-control" id="sentence" name="sentence" placeholder="Masukkan kalimat"
                        required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Periksa</button>
            </form>
            <div class="mt-3 show-result-frequency">
                <p class="text-center">
                    Hasil: <strong id="result-frequency"></strong>
                </p>
            </div>
        </div>
    </div>

    <div class="card m-3">
        <div class="card-body">
            <h5 class="card-title text-center">Matrix Generator</h5>
            <form id="matrix-form">
                @csrf
                <div class="form-group">
                    <label for="row">Row</label>
                    <input type="number" class="form-control" id="row" name="row" placeholder="Masukkan row pertama"
                        required>
                </div>
                <div class="form-group">
                    <label for="col">Col</label>
                    <input type="number" class="form-control" id="col" name="col" placeholder="Masukkan col kedua"
                        required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Generate</button>
            </form>
            <div class="mt-3 show-result-matrix">
                <p class="text-center">
                    Hasil:
                    <br>
                    <strong id="result-matrix"></strong>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#anagram-form').submit(function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                    url: "{{ route('anagram.check') }}",
                    type: "POST",
                    data: data,
                    success: function (data) {
                        $('#show-result').show();
                        $('#result').html(data.result);
                    },
                }
                );
            });

            $('#frequency-form').submit(function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                    url: "{{ route('frequency.check') }}",
                    type: "POST",
                    data: data,
                    success: function (data) {
                        $('#show-result-frequency').show();
                        $('#result-frequency').html('Huruf ' + data.result + ' muncul sebanyak ' + data.count + ' kali');
                    }
                });
            });

            $('#matrix-form').submit(function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                    url: "{{ route('matrix.generator') }}",
                    type: "POST",
                    data: data,
                    success: function (data) {
                        $('#show-result-matrix').show();

                        var matrixHtml = '<table class="table table-bordered">';
                        data.result.forEach(function (row) {
                            matrixHtml += '<tr>';
                            row.forEach(function (cell) {
                                matrixHtml += '<td>' + cell + '</td>';
                            });
                            matrixHtml += '</tr>';
                        });

                        matrixHtml += '</table>';
                        $('#result-matrix').html(matrixHtml);
                    }
                });
            });
        });
    </script>
@endpush