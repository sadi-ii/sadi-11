<?php
$conn = new mysqli("localhost", "root", "", "library_management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT id, title, author FROM books";
$result = $conn->query($sql);
$books = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}
$conn->close();
$tokens = [];
if (file_exists('token.json')) {
    $json = file_get_contents('token.json');
    $tokens = json_decode($json, true);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <title>Library Management</title>
</head>
<body>
    <main>
        <aside class="box3">
            <h2>Used Token</h2>
            <ul class="token-list">
                <?php foreach ($tokens as $token): ?>
                    <li><strong><?php echo htmlspecialchars($token['token']); ?></strong></li>
                <?php endforeach; ?>
            </ul>
        </aside>
        <div>
            <section>
            <div class="box1">
                    <h2 style="text-align: left; color:black;">Books Available In Library</h2>
                    <ul>
                        <?php foreach ($books as $book): ?>
                            <li><?php echo htmlspecialchars($book['title']) . " by " . htmlspecialchars($book['author']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="box1">
                    <h2 style="text-align: left; color:black;">Add Books / Remove Books From Library</h2>
                    <form action="add_remove_book.php" method="post">
                        <input type="text" name="title" placeholder="Book Title" required>
                        <input type="text" name="author" placeholder="Author" required>
                        <button style= "text-align: center" type="submit" name="action" value="add" id="buttonAdd"><b>Add</b></button>
                        <button style= "text-align: center" type="submit" name="action" value="remove" id="buttonRemove"><b>Remove</b></button>
                    </form>
                </div>
                <div class="box1">
                    <h2 style="text-align: left; color:black;">Edit Book Information</h2>
                    <form action="edit_book.php" method="post">
                        <input type="number" name="id" placeholder="Book ID" required>
                        <input type="text" name="title" placeholder="New Title">
                        <input type="text" name="author" placeholder="New Author">
                        <button style= "text-align: center" type="submit" id="buttonUpdate"><b>Update</b></button>
                    </form>
                </div>
            </section>
            <section class="section2">
                <div class = "box2">

                </div>
                <div class="box2">
                    
                    
                </div>
                <div class= "box2">

                </div>
            </section>
            <section class="section2">
                <div class="box22a">
                    <form action="process.php" method="post">
                        <b>Student Name</b> 
                        <br><input type="text" placeholder="Student Full Name" name="studentname" id="studentname" required><br>
                        <b>Student ID</b>
                        <br><input type="text" placeholder="Student ID" name="studentid" id="studentID" required><br>
                        <b>Student Email</b>
                        <br><input type="email" placeholder="Student Email" name="email" id="email" required><br>
                        <label for="booktitle"><b>Choose A Book Title: </b></label><br>
                        <select name="booktitle" id="booktitle" required>
                            <option value="Select a Book" disabled selected>Select a Book</option>
                            <option value="Harry Potter and the Philosopher's Stone">Harry Potter and the Philosopher's Stone</option>
                            <option value="Harry Potter and the Chamber of Secrets">Harry Potter and the Chamber of Secrets</option>
                            <option value="Harry Potter and the Prisoner of Azkaban">Harry Potter and the Prisoner of Azkaban</option>
                            <option value="Harry Potter and the Goblet of Fire">Harry Potter and the Goblet of Fire</option>
                            <option value="Harry Potter and the Order of the Phoenix">Harry Potter and the Order of the Phoenix</option>
                            <option value="Harry Potter and the Half-Blood Prince">Harry Potter and the Half-Blood Prince</option>
                            <option value="Harry Potter and the Deathly Hallows">Harry Potter and the Deathly Hallows</option>
                            <option value="Harry Potter and the Cursed Child">Harry Potter and the Cursed Child</option>
                        </select><br>
                        <b>Borrow date</b>
                        <br><input type="date" name="borrowdate" id="borrowdate" required><br>
                        <b>Return date</b>
                        <br><input type="date" name="returndate" id="returndate" required><br>
                        <b>Token</b>
                        <br><input type="text" placeholder="Token Number" name="token" id="token" required><br>
                        <b>Fees</b>
                        <br><input type="text" placeholder="Fees" name="fees" id="fees" required><br> <br><br>
                        <button type="submit" name="submit" id="button"><b>Borrow</b></button>
                    </form>
                </div>
                <?php
                if (file_exists('token.json')) {
                    $tokens_json = file_get_contents('token.json');
                    $tokens = json_decode($tokens_json, true);
                    if ($tokens === null) {
                        echo "Error decoding JSON.";
                    }
                } else {
                    echo "token.json file not found.";
                }
                ?>
                <div class="box22b">
                    <h3 style="text-align: center;">Available Tokens</h3>
                    <ul>
                        <?php if (isset($tokens) && is_array($tokens)): ?>
                            <?php foreach ($tokens as $token): ?>
                                <?php if (isset($token['token'])): ?>
                                    <ul type = "disc">
                                        <li><strong>
                                            <?php echo $token['token']; ?></strong>
                                        </li>
                                    </ul><br>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No tokens available or an error occurred while loading the tokens.</p>
                        <?php endif; ?>
                    </ul>
                </div>
            </section>
        </div>
        <div class="box3">
            <h2 style="text-align: left; color:white;">Library Information</h2><br>
            <p>
            <u>The library operates on the following schedule:</u><br>
            <br>
            <br>
            <u>Sunday to Thursday:</u> Open from 8:00 AM to 9:00 PM.<br>
            <br>
            These extended hours provide ample time for studying, research, and borrowing materials.<br>
            <br>
            <br>
            <u>Friday and Saturday:</u> The library is closed.<br>
            <br>
            On these days, staff prepare for the upcoming week, conduct maintenance, and update resources.<br>
            <br>
            <br>
            <br>
            <u>About Novel</u><br>
            <br>
            Novels transport readers into realms of imagination, creativity, and emotion. Among the most beloved series in the world of novels is the Harry Potter series by J.K. Rowling—a magical journey that has captured the hearts of millions across generations.<br>
            <br>
            <br>
            <u>The Harry Potter Series</u><br>
            <br>
            This iconic series chronicles the adventures of Harry Potter, an ordinary boy who discovers he is a wizard. Enrolling in the Hogwarts School of Witchcraft and Wizardry, Harry, along with his friends Hermione Granger and Ron Weasley, embarks on a thrilling journey filled with magic, mystery, and the fight against the dark forces led by Lord Voldemort.
            </p>

        </div>
    </main>
</body>
</html>