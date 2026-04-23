<?= $header ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Préstamos</title>

    <style>
        /* ===== RESET ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f7fb;
            color: #333;
        }

        /* ===== CONTENEDOR ===== */
        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 20px;
        }

        /* ===== TARJETAS ===== */
        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-top: 4px solid #163a5f;
        }

        .card h3 {
            margin-bottom: 15px;
            color: #163a5f;
        }

        /* ===== FORMULARIO ===== */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 14px;
            margin-bottom: 5px;
            color: #163a5f;
            font-weight: 600;
        }

        input {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #163a5f;
            box-shadow: 0 0 5px rgba(22, 58, 95, 0.3);
        }

        /* ===== BOTÓN ===== */
        .btn {
            background: #163a5f;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn:hover {
            background: #0f2c47;
        }

        /* ===== TABLA ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background: #163a5f;
            color: white;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
        }

        tbody tr {
            border-bottom: 1px solid #eee;
        }

        tbody tr:hover {
            background: #eaf2f9;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 600px) {
            .card h3 {
                font-size: 18px;
            }
        }
    </style>

</head>

<body>

    <div class="container">

        <!-- ===== FORMULARIO ===== -->
        <div class="card">
            <h3>Registrar Préstamo</h3>

            <form action="<?= base_url('prestamos/guardar') ?>" method="post">
                <div class="form-grid">

                    <div class="form-group">
                        <label>DNI Alumna</label>
                        <input type="text" name="alumna_id" required>
                    </div>

                    <div class="form-group">
                        <label>Nombre del Libro</label>
                        <input type="text" name="libro_id" required>
                    </div>

                    <div class="form-group">
                        <label>Fecha Préstamo</label>
                        <input type="date" name="fecha_prestamo" required>
                    </div>

                    <div class="form-group">
                        <label>Fecha Devolución</label>
                        <input type="date" name="fecha_devolucion" required>
                    </div>

                </div>

                <button type="submit" class="btn">Guardar Préstamo</button>
            </form>
        </div>

        <!-- ===== TABLA ===== -->
        <div class="card">
            <h3>Listado de Préstamos</h3>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Alumna</th>
                        <th>Libro</th>
                        <th>F. Préstamo</th>
                        <th>F. Devolución</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($prestamos)): ?>
                        <?php foreach ($prestamos as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td><?= $p['alumna_id'] ?></td>
                                <td><?= $p['libro_id'] ?></td>
                                <td><?= $p['fecha_prestamo'] ?></td>
                                <td><?= $p['fecha_devolucion'] ?></td>
                                <td><?= $p['estado'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No hay préstamos registrados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>

    </div>

</body>

</html>

<?= $footer ?>