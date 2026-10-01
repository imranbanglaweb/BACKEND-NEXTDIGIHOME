<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=nextdigihome', 'root', '');
$stmt = $pdo->query("SELECT id, name, slug, price, category, thumbnail, featured, active FROM products");
while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "#{$r['id']} | {$r['name']} | Cat: {$r['category']} | Price: ৳{$r['price']} | Active: {$r['active']} | Featured: {$r['featured']} | Thumb: {$r['thumbnail']}\n";
}
