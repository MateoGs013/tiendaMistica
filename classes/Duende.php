<?php
// classes/Duende.php
require_once __DIR__ . '/DB.php';

class Duende {

    private static array $rarezaPalette = [
        'legendario' => '#d946ef',
        'épico' => '#06b6d4',
        'raro' => '#fbbf24',
        'común' => '#38bdf8',
    ];

    private static array $elementoPalette = [
        'tierra' => '#22c55e',
        'agua' => '#0ea5e9',
        'fuego' => '#f97316',
        'aire' => '#a855f7',
        'sombra' => '#9333ea',
        'luz' => '#fde047',
    ];

    private static function rarezaColor(?string $rareza): string {
        $clave = strtolower(trim((string)$rareza));
        return self::$rarezaPalette[$clave] ?? '#06b6d4';
    }

    private static function elementoColor(?string $elemento): string {
        $clave = strtolower(trim((string)$elemento));
        return self::$elementoPalette[$clave] ?? '#6366f1';
    }

    private static function normalizarLista(mixed $valor): array {
        if (is_array($valor)) {
            return array_values(array_filter(array_map('trim', $valor), static fn($item) => $item !== ''));
        }

        if (is_string($valor)) {
            $valor = trim($valor);
            if ($valor === '') {
                return [];
            }
            if (str_contains($valor, ',')) {
                return self::normalizarLista(explode(',', $valor));
            }
            return [$valor];
        }

        return [];
    }

    private static function aplicarStatsDerivadas(array $fila): array {
        $popularidad = (int)($fila['popularidad'] ?? 0);
        $suerte = (int)($fila['nivel_suerte'] ?? 0);
        $maldad = (int)($fila['nivel_maldad'] ?? 0);
        $altura = (float)($fila['altura_cm'] ?? 0);

        $fila['poder_total'] = max(0, (int)round(($suerte * 3) + ((100 - $maldad) * 0.8) + ($popularidad * 1.5)));
        $fila['indice_suerte'] = round(($suerte * 0.7) + ($popularidad * 0.3), 1);
        $fila['nivel_riesgo'] = max(1, min(99, (int)round(($maldad * 1.25) - ($suerte * 0.4) + 20)));
        $fila['impacto_terreno'] = $altura > 0 ? round(min(99, ($altura / 60) * 100), 1) : null;
        $fila['rareza_color'] = self::rarezaColor($fila['rareza'] ?? null);
        $fila['elemento_color'] = self::elementoColor($fila['elemento'] ?? null);

        if (!empty($fila['accesorios'])) {
            $lista = array_filter(array_map('trim', explode('||', (string)$fila['accesorios'])));
            $fila['accesorios_list'] = array_values($lista);
        } else {
            $fila['accesorios_list'] = [];
        }

        return $fila;
    }

    public static function all(): array {
        try {
            $cn = DB::get();
            $sql = "SELECT d.id_duende, d.nombre, d.tipo, d.precio_en_oro, d.disponible,
                           r.nombre AS rareza, e.nombre AS elemento
                    FROM duendes d
                    LEFT JOIN rareza r ON r.id_rareza = d.id_rareza
                    LEFT JOIN elementos e ON e.id_elemento = d.id_elemento
                    ORDER BY d.popularidad DESC, d.id_duende DESC";
            $filas = $cn->query($sql)->fetchAll();
            return array_map([self::class, 'aplicarStatsDerivadas'], $filas);
        } catch (Exception $e) {
            error_log("Error al obtener todos los duendes: " . $e->getMessage());
            return [];
        }
    }

    public static function allDisponibles(): array {
        try {
            $cn = DB::get();
            $sql = "SELECT d.id_duende, d.nombre, d.tipo, d.precio_en_oro, d.disponible,
                           r.nombre AS rareza, e.nombre AS elemento
                    FROM duendes d
                    LEFT JOIN rareza r ON r.id_rareza = d.id_rareza
                    LEFT JOIN elementos e ON e.id_elemento = d.id_elemento
                    WHERE d.disponible = 1
                    ORDER BY d.popularidad DESC";
            $filas = $cn->query($sql)->fetchAll();
            return array_map([self::class, 'aplicarStatsDerivadas'], $filas);
        } catch (Exception $e) {
            error_log("Error al obtener duendes disponibles: " . $e->getMessage());
            return [];
        }
    }

    public static function catalogoInteractivo(array $filtros = [], bool $paginar = true): array {
        $resultado = [
            'items' => [],
            'total' => 0,
            'page' => 1,
            'pages' => 1,
            'per_page' => $paginar ? 9 : null,
        ];

        try {
            $cn = DB::get();

            $page = $paginar ? max(1, (int)($filtros['page'] ?? 1)) : 1;
            $perPage = $paginar ? min(24, max(3, (int)($filtros['per_page'] ?? 9))) : null;

            $soloDisponibles = $filtros['solo_disponibles'] ?? true;
            unset($filtros['solo_disponibles'], $filtros['page'], $filtros['per_page']);

            $conditions = [];
            $params = [];

            if ($soloDisponibles) {
                $conditions[] = 'd.disponible = 1';
            }

            if (!empty($filtros['id'])) {
                $conditions[] = 'd.id_duende = :id_duende';
                $params[':id_duende'] = (int)$filtros['id'];
            }

            if (!empty($filtros['rareza'])) {
                $ids = array_filter(array_map('intval', self::normalizarLista($filtros['rareza'])));
                if ($ids) {
                    $marcadores = [];
                    foreach ($ids as $i => $valor) {
                        $clave = ':rareza_' . $i;
                        $params[$clave] = $valor;
                        $marcadores[] = $clave;
                    }
                    $conditions[] = 'd.id_rareza IN (' . implode(',', $marcadores) . ')';
                }
            }

            if (!empty($filtros['elemento'])) {
                $ids = array_filter(array_map('intval', self::normalizarLista($filtros['elemento'])));
                if ($ids) {
                    $marcadores = [];
                    foreach ($ids as $i => $valor) {
                        $clave = ':elemento_' . $i;
                        $params[$clave] = $valor;
                        $marcadores[] = $clave;
                    }
                    $conditions[] = 'd.id_elemento IN (' . implode(',', $marcadores) . ')';
                }
            }

            if (!empty($filtros['material'])) {
                $ids = array_filter(array_map('intval', self::normalizarLista($filtros['material'])));
                if ($ids) {
                    $marcadores = [];
                    foreach ($ids as $i => $valor) {
                        $clave = ':material_' . $i;
                        $params[$clave] = $valor;
                        $marcadores[] = $clave;
                    }
                    $conditions[] = 'd.id_material IN (' . implode(',', $marcadores) . ')';
                }
            }

            if (!empty($filtros['precio_min'])) {
                $conditions[] = 'd.precio_en_oro >= :precio_min';
                $params[':precio_min'] = (float)$filtros['precio_min'];
            }

            if (!empty($filtros['precio_max'])) {
                $conditions[] = 'd.precio_en_oro <= :precio_max';
                $params[':precio_max'] = (float)$filtros['precio_max'];
            }

            if (!empty($filtros['q'])) {
                $conditions[] = '(d.nombre LIKE :busqueda OR d.descripcion LIKE :busqueda OR d.tipo LIKE :busqueda OR a.nombre LIKE :busqueda)';
                $params[':busqueda'] = '%' . trim((string)$filtros['q']) . '%';
            }

            if (!empty($filtros['poder_min'])) {
                $conditions[] = '(COALESCE(d.nivel_suerte,0) * 3 + COALESCE(d.popularidad,0)) >= :poder_min';
                $params[':poder_min'] = (int)$filtros['poder_min'];
            }

            $where = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

            $orden = strtolower((string)($filtros['orden'] ?? 'popularidad'));
            $ordenes = [
                'popularidad' => 'd.popularidad DESC, d.id_duende DESC',
                'precio_asc' => 'd.precio_en_oro ASC',
                'precio_desc' => 'd.precio_en_oro DESC',
                'suerte' => 'd.nivel_suerte DESC',
                'riesgo' => 'd.nivel_maldad ASC',
                'reciente' => 'd.fecha_creacion DESC',
                'antiguo' => 'd.fecha_creacion ASC',
            ];
            $orderSql = $ordenes[$orden] ?? $ordenes['popularidad'];

            $joins = "
                LEFT JOIN rareza r ON r.id_rareza = d.id_rareza
                LEFT JOIN elementos e ON e.id_elemento = d.id_elemento
                LEFT JOIN materiales m ON m.id_material = d.id_material
                LEFT JOIN duende_accesorios da ON da.id_duende = d.id_duende
                LEFT JOIN accesorios a ON a.id_accesorio = da.id_accesorio
            ";

            $sqlBase = "FROM duendes d
                $joins
                $where";

            $sqlConteo = "SELECT COUNT(DISTINCT d.id_duende) AS total $sqlBase";
            $stConteo = $cn->prepare($sqlConteo);
            foreach ($params as $clave => $valor) {
                $tipo = is_int($valor) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stConteo->bindValue($clave, $valor, $tipo);
            }
            $stConteo->execute();
            $total = (int)($stConteo->fetch()['total'] ?? 0);

            $sqlDatos = "SELECT d.*, r.nombre AS rareza, e.nombre AS elemento, m.nombre AS material,
                            GROUP_CONCAT(DISTINCT a.nombre ORDER BY a.nombre SEPARATOR '||') AS accesorios
                        $sqlBase
                        GROUP BY d.id_duende
                        ORDER BY $orderSql";

            if ($paginar && $perPage !== null) {
                $sqlDatos .= " LIMIT :limit OFFSET :offset";
            }

            $stDatos = $cn->prepare($sqlDatos);
            foreach ($params as $clave => $valor) {
                $tipo = is_int($valor) ? PDO::PARAM_INT : PDO::PARAM_STR;
                if (is_float($valor)) {
                    $tipo = PDO::PARAM_STR;
                }
                $stDatos->bindValue($clave, $valor, $tipo);
            }

            if ($paginar && $perPage !== null) {
                $offset = ($page - 1) * $perPage;
                $stDatos->bindValue(':limit', $perPage, PDO::PARAM_INT);
                $stDatos->bindValue(':offset', $offset, PDO::PARAM_INT);
            }

            $stDatos->execute();
            $items = $stDatos->fetchAll();

            $resultado['items'] = array_map([self::class, 'aplicarStatsDerivadas'], $items);
            $resultado['total'] = $total;
            $resultado['page'] = $page;
            $resultado['per_page'] = $paginar ? $perPage : $total;
            $resultado['pages'] = $paginar && $perPage ? max(1, (int)ceil($total / $perPage)) : 1;

            return $resultado;
        } catch (Exception $e) {
            error_log('Error en catalogoInteractivo: ' . $e->getMessage());
            return $resultado;
        }
    }

    public static function filtrosDisponibles(): array {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }

        if (!empty($_SESSION['catalogo_cache']['filtros']) && ($_SESSION['catalogo_cache']['filtros']['expira'] ?? 0) > time()) {
            return $_SESSION['catalogo_cache']['filtros']['data'];
        }

        try {
            $cn = DB::get();
            $filtros = [
                'rarezas' => $cn->query("SELECT id_rareza, nombre FROM rareza ORDER BY nombre ASC")->fetchAll(),
                'elementos' => $cn->query("SELECT id_elemento, nombre FROM elementos ORDER BY nombre ASC")->fetchAll(),
                'materiales' => $cn->query("SELECT id_material, nombre FROM materiales ORDER BY nombre ASC")->fetchAll(),
                'rangos' => $cn->query("SELECT MIN(precio_en_oro) AS minimo, MAX(precio_en_oro) AS maximo FROM duendes WHERE disponible = 1")->fetch(),
            ];

            $_SESSION['catalogo_cache']['filtros'] = [
                'expira' => time() + 600,
                'data' => $filtros,
            ];

            return $filtros;
        } catch (Exception $e) {
            error_log('Error al cargar filtros de catálogo: ' . $e->getMessage());
            return [
                'rarezas' => [],
                'elementos' => [],
                'materiales' => [],
                'rangos' => ['minimo' => null, 'maximo' => null],
            ];
        }
    }

    public static function detalleEnriquecido(int $id): ?array {
        $data = self::catalogoInteractivo([
            'id' => $id,
            'solo_disponibles' => false,
        ], false);

        $registro = $data['items'][0] ?? null;
        return $registro ?: null;
    }

    public static function find(int $id): ?array {
        return self::detalleEnriquecido($id);
    }

    // Métodos base listos para el ABM de admin
    public static function create(array $data): bool {
        try {
            $cn = DB::get();
            $sql = "INSERT INTO duendes
                (nombre,tipo,color_principal,altura_cm,personalidad,id_rareza,precio_en_oro,
                 efecto_magico,id_elemento,nivel_maldad,nivel_suerte,origen_mitologico,
                 id_material,disponible,fecha_creacion,popularidad,recomendado_para,
                 advertencias,imagen_url,descripcion)
                VALUES
                (:nombre,:tipo,:color_principal,:altura_cm,:personalidad,:id_rareza,:precio_en_oro,
                 :efecto_magico,:id_elemento,:nivel_maldad,:nivel_suerte,:origen_mitologico,
                 :id_material,:disponible,:fecha_creacion,:popularidad,:recomendado_para,
                 :advertencias,:imagen_url,:descripcion)";
            $st = $cn->prepare($sql);
            return $st->execute($data);
        } catch (Exception $e) {
            error_log("Error al crear duende: " . $e->getMessage());
            return false;
        }
    }

    public static function update(int $id, array $data): bool {
        try {
            $cn = DB::get();
            $data['id'] = $id;
            $sql = "UPDATE duendes SET
                nombre=:nombre,
                tipo=:tipo,
                color_principal=:color_principal,
                altura_cm=:altura_cm,
                personalidad=:personalidad,
                id_rareza=:id_rareza,
                precio_en_oro=:precio_en_oro,
                efecto_magico=:efecto_magico,
                id_elemento=:id_elemento,
                nivel_maldad=:nivel_maldad,
                nivel_suerte=:nivel_suerte,
                origen_mitologico=:origen_mitologico,
                id_material=:id_material,
                disponible=:disponible,
                fecha_creacion=:fecha_creacion,
                popularidad=:popularidad,
                recomendado_para=:recomendado_para,
                advertencias=:advertencias,
                imagen_url=:imagen_url,
                descripcion=:descripcion
                WHERE id_duende=:id";
            $st = $cn->prepare($sql);
            return $st->execute($data);
        } catch (Exception $e) {
            error_log("Error al actualizar duende ID $id: " . $e->getMessage());
            return false;
        }
    }

    public static function delete(int $id): bool {
        try {
            $cn = DB::get();
            $st = $cn->prepare("DELETE FROM duendes WHERE id_duende = ?");
            return $st->execute([$id]);
        } catch (Exception $e) {
            error_log("Error al eliminar duende ID $id: " . $e->getMessage());
            return false;
        }
    }
}
