<!DOCTYPE html>
<html>
<head>
    <title>Form Upload Produk ke Instagram</title>
</head>
<body>
    <h2>Posting Produk ke Instagram</h2>
    <form action="post.php" method="POST" enctype="multipart/form-data">
        <label>Judul Produk:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Deskripsi Produk:</label><br>
        <textarea name="description" rows="5" required></textarea><br><br>

        <label>Gambar Produk:</label><br>
        <input type="file" name="image" accept="image/*" required><br><br>

        <button type="submit">Posting ke Instagram</button>
    </form>
</body>
</html>
