<!DOCTYPE html>
<html>
<head>
    <title>Simulazione Pagamento</title>
</head>
<body>
    @if ($result->success)
        <p>Transazione riuscita. ID Transazione: {{ $result->transaction->id }}</p>
    @else
        <p>Transazione fallita. Errore: {{ $result->message }}</p>
    @endif
</body>
</html>