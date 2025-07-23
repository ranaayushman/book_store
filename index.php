<?php
// /var/www/html/index.php
session_start();
require 'db.php';

// Redirect to login if user is not logged in
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
        "description": "Between life and death there is a library, and within that library, the shelves go on forever. Every book provides a chance to try another life you could have lived.",
        "cover_image": "https://images-na.ssl-images-amazon.com/images/I/81AI+2D45YL.jpg"
    },
    {
        "id": "2",
        "title": "Project Hail Mary",
        "author": "Andy Weir",
        "price": 18.50,
        "description": "A lone astronaut must save the earth from disaster in this cinematic thriller full of suspense, humor, and fascinating science—from the author of The Martian.",
        "cover_image": "https://images-na.ssl-images-amazon.com/images/I/91+N9A26m5L.jpg"
    },
    {
        "id": "3",
        "title": "Klara and the Sun",
        "author": "Kazuo Ishiguro",
        "price": 16.95,
        "description": "A magnificent new novel from the Nobel laureate Kazuo Ishiguro—author of Never Let Me Go and the Booker Prize-winning The Remains of the Day.",
        "cover_image": "https://images-na.ssl-images-amazon.com/images/I/71DONk2+T9L.jpg"
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
// --- END FAKE API ---

// Conversion rate (example)
$usd_to_inr_rate = 83.50;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Book Nook - Home</title>
    <link href="/dist/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <header class="bg-white shadow-sm sticky top-0 z-20">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-extrabold text-blue-600">The Book Nook</a>
            <div class="flex items-center space-x-4">
                <span class="text-gray-700 hidden sm:block">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
                <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors font-semibold">Logout</a>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-6 py-10">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-3">Find Your Next Great Read</h1>
            <p class="text-lg text-gray-600">Explore our curated collection of bestsellers and hidden gems.</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <?php foreach ($books as $book): ?>
                <a href="details.php?id=<?php echo $book['id']; ?>" class="block bg-white rounded-lg shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden group">
                    <div class="h-72 overflow-hidden">
                        <img src="<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover of <?php echo htmlspecialchars($book['title']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.onerror=null;this.src='https://placehold.co/400x600/e2e8f0/333?text=Image+Not+Found';">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 mb-2 truncate"><?php echo htmlspecialchars($book['title']); ?></h3>
                        <p class="text-gray-600 text-sm mb-4">by <?php echo htmlspecialchars($book['author']); ?></p>
                        <div class="text-xl font-extrabold text-blue-600">₹<?php echo number_format($book['price'] * $usd_to_inr_rate, 2); ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
