<?php
// /var/www/html/details.php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// --- FAKE BOOK API ---
$books_json = <<<JSON
[
    {
        "id": "1",
        "title": "The Midnight Library",
        "author": "Matt Haig",
        "price": 14.99,
        "description": "Between life and death there is a library, and within that library, the shelves go on forever. Every book provides a chance to try another life you could have lived. To see how things would be if you had made other choices . . . Would you have done anything different, if you had the chance to undo your regrets?",
        "cover_image": "https://images-na.ssl-images-amazon.com/images/I/81AI+2D45YL.jpg"
    },
    {
        "id": "2",
        "title": "Project Hail Mary",
        "author": "Andy Weir",
        "price": 18.50,
        "description": "Ryland Grace is the sole survivor on a desperate, last-chance mission—and if he fails, humanity and the earth itself will perish. Except that right now, he doesn't know that. He can't even remember his own name, let alone the nature of his assignment or how to complete it.",
        "cover_image": "https://images-na.ssl-images-amazon.com/images/I/91+N9A26m5L.jpg"
    },
    {
        "id": "3",
        "title": "Klara and the Sun",
        "author": "Kazuo Ishiguro",
        "price": 16.95,
        "description": "Here is the story of Klara, an Artificial Friend with outstanding observational qualities, who, from her place in the store, watches carefully the behavior of those who come in to browse, and of those who pass on the street outside. She remains hopeful that a customer will soon choose her.",
        "cover_image": "https://images-na.ssl-images-amazon.com/images/I/71DONk2+T9L.jpg"
    },
    {
        "id": "4",
        "title": "Dune",
        "author": "Frank Herbert",
        "price": 10.99,
        "description": "Set on the desert planet Arrakis, Dune is the story of the boy Paul Atreides, heir to a noble family tasked with ruling an inhospitable world where the only thing of value is the “spice” melange, a drug capable of extending life and enhancing consciousness.",
        "cover_image": "https://images-na.ssl-images-amazon.com/images/I/81ym3QUd3KL.jpg"
    }
]
JSON;
$books = json_decode($books_json, true);
// --- END FAKE API ---

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
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="max-w-5xl mx-auto p-4 md:p-6 lg:p-8">
        <a href="index.php" class="text-blue-500 hover:underline mb-6 inline-block text-sm md:text-base">&larr; Back to Collection</a>

        <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg flex flex-col lg:flex-row gap-8">
            <!-- Book Cover -->
            <div class="flex justify-center lg:justify-start">
                <img 
                    src="<?php echo htmlspecialchars($book['cover_image']); ?>" 
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
                        <button type="submit" class="w-full sm:w-auto bg-green-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-green-600 transition-colors text-md shadow-md hover:shadow-lg">
                            Order Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
