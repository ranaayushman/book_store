<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$books_json = <<<JSON
[
    {
        "id": "1",
        "title": "The Midnight Library",
        "author": "Matt Haig",
        "price": 14.99,
        "description": "Between life and death there is a library, and within that library, the shelves go on forever. Every book provides a chance to try another life you could have lived.",
        "cover_image": "https://m.media-amazon.com/images/I/419X9dVWmJL._SY445_SX342_ControlCacheEqualizer_.jpg"
    },
    {
        "id": "2",
        "title": "Project Hail Mary",
        "author": "Andy Weir",
        "price": 18.50,
        "description": "A lone astronaut must save the earth from disaster in this cinematic thriller full of suspense, humor, and fascinating science—from the author of The Martian.",
        "cover_image": "https://m.media-amazon.com/images/I/81Ck2nTaH2L.jpg"
    },
    {
        "id": "3",
        "title": "Klara and the Sun",
        "author": "Kazuo Ishiguro",
        "price": 16.95,
        "description": "A magnificent new novel from the Nobel laureate Kazuo Ishiguro—author of Never Let Me Go and the Booker Prize-winning The Remains of the Day.",
        "cover_image": "https://m.media-amazon.com/images/I/913Op5vZ3ML._UF1000,1000_QL80_.jpg"
    },
    {
        "id": "4",
        "title": "Dune",
        "author": "Frank Herbert",
        "price": 10.99,
        "description": "A stunning blend of adventure and mysticism, environmentalism and politics, Dune won the first Nebula Award, shared the Hugo Award, and formed the basis of what is undoubtedly the grandest epic in science fiction.",
        "cover_image": "https://images-na.ssl-images-amazon.com/images/I/81ym3QUd3KL.jpg"
    }
]
JSON;
$books = json_decode($books_json, true);


$usd_to_inr_rate = 83.50;

$book_id = $_GET['id'] ?? null;
$book = null;

foreach ($books as $b) {
    if ($b['id'] == $book_id) {
        $book = $b;
        break;
    }
}

if (!$book) {
    echo "Book not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['title']); ?> - The Book Nook</title>
    <link href="/dist/output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="max-w-5xl mx-auto p-4 md:p-6 lg:p-8">
        <a href="index.php" class="text-blue-500 hover:underline mb-6 inline-block text-sm md:text-base">&larr; Back to
            Collection</a>

        <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg flex flex-col lg:flex-row gap-8">
            <!-- Book Cover -->
            <div class="flex justify-center lg:justify-start">
                <img src="<?php echo htmlspecialchars($book['cover_image']); ?>"
                    alt="Cover of <?php echo htmlspecialchars($book['title']); ?>"
                    class="w-full max-w-xs md:max-w-sm h-auto object-contain rounded-lg shadow-md"
                    onerror="this.onerror=null;this.src='https://placehold.co/400x600/e2e8f0/333?text=Image+Not+Found';">
            </div>

            <!-- Book Info -->
            <div class="flex-1 flex flex-col">
                <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2">
                    <?php echo htmlspecialchars($book['title']); ?>
                </h1>
                <h3 class="text-lg md:text-xl text-gray-600 mb-4">
                    by <?php echo htmlspecialchars($book['author']); ?>
                </h3>
                <p class="text-gray-700 leading-relaxed mb-6 flex-grow text-sm md:text-base">
                    <?php echo nl2br(htmlspecialchars($book['description'])); ?>
                </p>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-auto pt-4 border-t">
                    <span class="text-2xl md:text-3xl font-bold text-blue-600 mb-4 sm:mb-0">
                        ₹<?php echo number_format($book['price'] * $usd_to_inr_rate, 2); ?>
                    </span>
                    <form action="order.php" method="post">
                        <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                        <input type="hidden" name="book_title" value="<?php echo htmlspecialchars($book['title']); ?>">
                        <button type="submit"
                            class="w-full sm:w-auto bg-green-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-green-600 transition-colors text-md shadow-md hover:shadow-lg">
                            Order Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>