<html>
<head>
    <title>Fix Formating</title>
</head>
<body>
    <form action="<?= base_url('Formating/fix_format')?>" method="POST" enctype="multipart/form-data">
        <input type="file" name="user_file" required accept=".xlsx">
        <input type="submit" name="submit" value="Kirim">
    </form>
</body>
</html>