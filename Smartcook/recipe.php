<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="recipe.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300&display=swap" rel="stylesheet">
</head>
<body>

<?php

        require_once("SmartCookClient.php");

        if (isset($_GET['name'])) {
            $recipe_name = urldecode($_GET['name']);

            $request_data = [
                "attributes" => ["name", "description", "image"],
                "filter" => [
                    "name" => $recipe_name
                ]
            ];

            $client = new SmartCookClient();
            $client->setRequestData($request_data);
            $client->sendRequest("recipe_details");

            $data = [];
            if (method_exists($client, 'getResponseData')) {
                $response = $client->getResponseData();

                if (isset($response['data']) && !empty($response['data'])) {
                    $data = $response['data'][0];
                } else {
                    echo "Recept nebyl nalezen.";
                }
            } else {
                echo "Nepodařilo se získat data z API.";
            }
        } else {
            echo "Není zadán název receptu.";
        }

?>


    <header>
        <div class="subtitle">
            <h1><strong>Smartcook Recipes</strong></h1>
            <p>Discover a variety of healthy and delicious recipes.</p>
        </div>

    </header>

    <main>

        <div class="picture">
            <img src="pictures/<?= isset($data['image']) ? $data['image'] : 'default.webp'; ?>" alt="<?= htmlspecialchars($recipe_name); ?>">

        </div>

        <div class="des">
            <p><?= isset($data['description']) ? htmlspecialchars($data['description']) : 'Popis není k dispozici'; ?></p>
        </div>


    </main>
    
    <footer>

    </footer>


    
</body>
</html>