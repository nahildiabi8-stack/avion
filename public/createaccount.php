<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/tailwind/output.css" rel="stylesheet">
    <title>Inscription - ComparOperator</title>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen select-none">

    <form action="../src/Controllers/register_process.php" method="POST" class="bg-white p-8 rounded shadow w-full max-w-md flex flex-col gap-4">

        <h1 class="text-2xl font-bold">Inscription</h1>

        <div class="flex flex-col gap-1">
            <label for="nom">Nom</label>
            <input id="nom" name="nom" type="text" required class="border rounded p-2">
        </div>

        <div class="flex flex-col gap-1">
            <label for="prenom">Prénom</label>
            <input id="prenom" name="prenom" type="text" required class="border rounded p-2">
        </div>

        <div class="flex flex-col gap-1">
            <label for="age">Âge</label>
            <input id="age" name="age" type="number"  required class="border rounded p-2">
        </div>

        <div class="flex flex-col gap-1">
            <label for="sexe">Sexe</label>
            <select id="sexe" name="sexe" required class="border rounded p-2">
                <option value="">-- Choisir --</option>
                <option value="homme">Homme</option>
                <option value="femme">Femme</option>
            </select>
        </div>

     

        <button type="submit" class="bg-blue-600 text-white rounded p-2 font-semibold hover:bg-blue-700">
            S'inscrire
        </button>

    </form>

</body>

</html>