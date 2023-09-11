@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form id="registration-form" method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-4 row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required minlength="3" autocomplete="name" autofocus>
                                    <span id="name-error" class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">
                                    <span id="email-error" class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="surname"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Surname') }}</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text"
                                        class="form-control @error('surname') is-invalid @enderror" name="surname"
                                        value="{{ old('surname') }}" required minlength="3" autocomplete="surname" autofocus>
                                    <span id="surname-error" class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="date_of_birth"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Birth date') }}</label>

                                <div class="col-md-6">
                                    <input id="date_of_birth" type="date"
                                        class="form-control @error('date_of_birth') is-invalid @enderror"
                                        name="date_of_birth" value="{{ old('date_of_birth') }}" required
                                        autocomplete="email">
                                    <span id="date_of_birth-error" class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">
                                    <span id="password-error" class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                    <span id="password-confirm-error" class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4 row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="button" class="btn btn-primary" id="register-button">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aggiungi questo script per la validazione client-side -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const registrationForm = document.getElementById("registration-form");
            const registerButton = document.getElementById("register-button");
            const nameField = document.getElementById("name");
            const emailField = document.getElementById("email");
            const surnameField = document.getElementById("surname");
            const dateOfBirthField = document.getElementById("date_of_birth");
            const passwordField = document.getElementById("password");
            const passwordConfirmField = document.getElementById("password-confirm");

            registerButton.addEventListener("click", function() {
                if (validateForm()) {
                    // Se la validazione è riuscita, invia il form
                    registrationForm.submit();
                }
            });

            function validateForm() {
                let isValid = true;

                // Validazione del campo "Name"
                const nameValue = nameField.value.trim();
                if (nameValue === "") {
                    isValid = false;
                    document.getElementById("name-error").innerHTML = "Il campo 'Name' è obbligatorio.";
                    nameField.classList.add("is-invalid");
                } 
                else if (nameValue.length < 3){
                    isValid = false;
                    document.getElementById("name-error").innerHTML = "Il campo 'Name' deve contenere almeno 3 caratteri";
                    nameField.classList.add("is-invalid");
                }
                else {
                    document.getElementById("name-error").innerHTML = "";
                    nameField.classList.remove("is-invalid");
                }

                // Validazione del campo "Email"
                const emailValue = emailField.value.trim();
                if (emailValue === "") {
                    isValid = false;
                    document.getElementById("email-error").innerHTML = "Il campo 'E-Mail Address' è obbligatorio.";
                    emailField.classList.add("is-invalid");
                } else if (!isValidEmail(emailValue)) {
                    isValid = false;
                    document.getElementById("email-error").innerHTML = "Inserisci un indirizzo email valido.";
                    emailField.classList.add("is-invalid");
                } else {
                    document.getElementById("email-error").innerHTML = "";
                    emailField.classList.remove("is-invalid");
                }

                // Validazione del campo "Surname"
                const surnameValue = surnameField.value.trim();
                if (surnameValue === "") {
                    isValid = false;
                    document.getElementById("surname-error").innerHTML = "Il campo 'Surname' è obbligatorio.";
                    surnameField.classList.add("is-invalid");
                } 
                else if(surnameValue.length < 3){
                    isValid = false;
                    document.getElementById("surname-error").innerHTML = "Il campo 'Surname' deve contenere almeno 3 caratteri";
                    surnameField.classList.add("is-invalid");
                }
                else {
                    document.getElementById("surname-error").innerHTML = "";
                    surnameField.classList.remove("is-invalid");
                }
                console.log(dateOfBirthField.value);
                const dateOfBirthValue = dateOfBirthField.value.trim();
                if (dateOfBirthValue === "") {
                    isValid = false;
                    document.getElementById("date_of_birth-error").innerHTML =
                        "Il campo 'Birth date' è obbligatorio.";
                    dateOfBirthField.classList.add("is-invalid");
                } else {
                    const currentDate = new Date();
                    const year = currentDate.getFullYear();
                    var month = currentDate.getMonth() + 1;

                    if (month < 10) {
                        month = "0" + month;
                    }
                    var day = currentDate.getDay();

                    const formattedDate = `${year}-${month}-${day}`;

                    console.log(formattedDate);
                    console.log(dateOfBirthValue);

                    if (dateOfBirthValue >= formattedDate) {
                        isValid = false;
                        document.getElementById("date_of_birth-error").innerHTML =
                            "La data di nascita deve essere precedente alla data odierna.";
                        dateOfBirthField.classList.add("is-invalid");
                    } else {
                        document.getElementById("date_of_birth-error").innerHTML = "";
                        dateOfBirthField.classList.remove("is-invalid");
                    }
                }

                // Validazione del campo "Password"
                const passwordValue = passwordField.value.trim();
                if (passwordValue.length < 8) {
                    isValid = false;
                    document.getElementById("password-error").innerHTML =
                        "La password deve essere lunga almeno 8 caratteri.";
                    passwordField.classList.add("is-invalid");
                } else {
                    document.getElementById("password-error").innerHTML = "";
                    passwordField.classList.remove("is-invalid");
                }

                // Validazione del campo "Confirm Password"
                const passwordConfirmValue = passwordConfirmField.value.trim();
                if (passwordConfirmValue !== passwordValue) {
                    isValid = false;
                    document.getElementById("password-confirm-error").innerHTML = "Le password non corrispondono.";
                    passwordConfirmField.classList.add("is-invalid");
                } else {
                    document.getElementById("password-confirm-error").innerHTML = "";
                    passwordConfirmField.classList.remove("is-invalid");
                }

                return isValid;
            }

            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }
        });
    </script>
@endsection
