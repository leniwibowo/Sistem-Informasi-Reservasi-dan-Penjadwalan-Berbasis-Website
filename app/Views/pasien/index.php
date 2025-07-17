<!DOCTYPE html>
<html>

<head>
    <title>Daftar Pasien</title>
</head>

<body>
    <h1>Data Pasien</h1>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Nama</th>
            <th>Username</th>
            <th>No HP</th>
            <th>No RM</th>
            <th>NIK</th>
        </tr>
        <?php if (!empty($pasien)) : ?>
            <?php foreach ($pasien as $p): ?>
                <tr>
                    <td><?= esc($p['nama']) ?></td>
                    <td><?= esc($p['username']) ?></td>
                    <td><?= esc($p['no_hp']) ?></td>
                    <td><?= esc($p['no_RM']) ?></td>
                    <td><?= esc($p['NIK']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Belum ada data pasien.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <title>Daftar Pasien</title>
</head>

<body>
    <h1>Data Pasien</h1>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Nama</th>
            <th>Username</th>
            <th>No HP</th>
            <th>No RM</th>
            <th>NIK</th>
        </tr>
        <?php if (!empty($pasien)) : ?>
            <?php foreach ($pasien as $p): ?>
                <tr>
                    <td><?= esc($p['nama']) ?></td>
                    <td><?= esc($p['username']) ?></td>
                    <td><?= esc($p['no_hp']) ?></td>
                    <td><?= esc($p['no_RM']) ?></td>
                    <td><?= esc($p['NIK']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Belum ada data pasien.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>

</html>