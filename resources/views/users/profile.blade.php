@extends('layout.master')

<style>
    .card {
        margin: 7% auto;
        background-color: #FAFAFA !important;
    }
    .actions-container {
        display: flex;
        gap: 60px;
        margin-top: 2rem;
        margin-left: 0;
    }
    .action-link {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 500;
        color: #6c757d;
        text-decoration: none;
        transition: all 0.6s ease;
    }
    .action-link i {
        background-color: #FCFCFC;
        color: #344264;
        padding: 16px 16px;
        border-radius: 25px;
        transition: all 0.6s ease;
    }
    .action-link:hover{
        background-color: #FCFCFC;
        padding-right: 16px;
        border-radius: 25px;
    }
    .action-link:hover i {
        color: #FCFCFC;
        background-color: #344264;
    }
</style>

@section('content')
    <main class="content-fluid py-5">
        <div class="container">
            <div class="card position-relative border-0 rounded-4 shadow-sm pb-4" style="width:60%">
                <div class="card-body mt-4">
                    <div class="actions-container">
                        <a href="{{ route('users.reset-password-form', auth()->id()) }}" class="action-link">
                            <i class="fas fa-key" me-2></i> Réinitialiser le mot de passe
                        </a>
                        <a href="{{ route('users.edit', auth()->id()) }}" class="action-link">
                            <i class="fas fa-user-edit me-2" style="padding: 16px 14px !important;"></i> Modifier votre profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
