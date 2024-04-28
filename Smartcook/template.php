<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smartcook</title>
    <link rel="stylesheet" href="template.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <div class="subtitle">
            <h1><strong>Smartcook Recipes</strong></h1>
            <p>Discover a variety of healthy and delicious recipes.</p>
        </div>
    </header>

    <main>

        <!-- Filters -->

        <nav>

            <div class="upper-menu">
                <div class="dropdown">
                    <button>Category <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg></button>
            
                    <div class="content">
                        <a href="">Breakfast</a>
                        <a href="">Soup</a>
                        <a href="">Main course</a>
                        <a href="">Dessert</a>
                        <a href="">Dinner</a>
                    </div>
                </div>
        
                <div class="dropdown">
                    <button>Difficulty <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg></button>
                    <div class="content">
                        <a href="">Easy</a>
                        <a href="">Medium</a>
                        <a href="">Hard</a>
                    </div>
                </div>
        
                <div class="dropdown dropdown-sort">
                    <button>Price <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg></button>
                    <div class="content">
                        <a href="">Cheap</a>
                        <a href="">Medium</a>
                        <a href="">Expensive</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Recipes -->

    <div class="recipes">
        
    <?php


        $recipe_images = [
            "Caprese salad" => "salad.webp",
            "Chocolate Mouse" => "chocolate.webp",
            "Scrambled Eggs" => "eggs.webp",
            "Spaghetti bolognese" => "main-course.webp",
            "Tomato soup" => "soup.webp"
        ];

        $recipe_descriptions = [
            "Caprese salad" => "Easy | 15 min | Dinner",
            "Chocolate Mouse" => "Medium | 60 min | Dessert",
            "Scrambled Eggs" => "Easy | 20 min | Breakfast",
            "Spaghetti bolognese" => "Medium | 30 min | Main course",
            "Tomato soup" => "Hard | 60 min | Soup"
        ];

        require_once("SmartCookClient.php");

        $request_data = [
            "attributes" => ["id", "name", "author"],
            "filter" => [
                "author" => ["Fárek Matěj"],
            ]
        ];

        try {
            $client = new SmartCookClient();
            $client->setRequestData($request_data);
            $client->sendRequest("recipes");

            if (method_exists($client, 'getResponseData')) {
                $response = $client->getResponseData();

                if (isset($response['data'])) {
                    $data = $response['data'];
                    foreach ($data as $recipe) {
                        $recipe_name = $recipe['name'];
                        $image_name = isset($recipe_images[$recipe_name]) ? $recipe_images[$recipe_name] : "default.webp";
                        $description = isset($recipe_descriptions[$recipe_name]) ? $recipe_descriptions[$recipe_name] : "No description available";
                        
                        echo '<a href="recipe.php?name=' . urlencode($recipe_name) . '" class="recipe">';
                        echo '<img src="pictures/' . $image_name . '" alt="">';
                        echo '<p class="name">' . $recipe_name . '</p>';
                        echo '<p>' . $description . '</p>';
                        echo '</a>';
                    }
                } else {
                    echo "Key 'data' is not found in the answer.";
                }
            } else {
                echo "Method getResponseData() does not exist in class SmartCookClient.";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    ?>


    </div>

    </main>

    <footer> <p>Smartcook&copy;2024 </p> </footer>

    
</body>
</html>