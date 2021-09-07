@extends('layouts.master')


@section('pageCustomStyle')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@stop


@section('content')

      <!-- Main Content -->
<div class="main-content">
    <div class="card">
        <div class="card-header">
            <h4>Liste des roles</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-md">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>Désignation du role</th>
                            <th>Nombre d'utilisateurs</th>
                            <th>Priorité</th>
                            <th>Actions</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Super Admin</td>
                            <td>4</td>
                            <td>
                                <div class="badge badge-danger">1</div>
                            </td>
                            <td>
                                <a href="#" class="btn btn-primary">Voir les utilisateurs</a>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Admin</td>
                            <td>2</td>
                            <td>
                                <div class="badge badge-success">2</div>
                            </td>
                            <td>
                                <a href="#" class="btn btn-primary">Voir les utilisateurs</a>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Utilisateur</td>
                            <td>7</td>
                            <td>
                                <div class="badge badge-primary">3</div>
                            </td>
                            <td>
                                <a href="#" class="btn btn-primary">Voir les utilisateurs</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-right">
            <nav class="d-inline-block">
                <ul class="pagination mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1 <span
                                class="sr-only">(current)</span></a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endsection


@section('pageCustomScript')
  <script src="{{ asset('assets/js/custom.js') }}"></script>

@stop