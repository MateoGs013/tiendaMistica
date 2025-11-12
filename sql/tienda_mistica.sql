-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2025 a las 17:19:00
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_mistica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesorios`
--

CREATE TABLE `accesorios` (
  `id_accesorio` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `accesorios`
--

INSERT INTO `accesorios` (`id_accesorio`, `nombre`) VALUES
(34, 'amuletos de guerra'),
(37, 'anillo de ceniza'),
(18, 'anillo de protección'),
(7, 'arpa diminuta'),
(2, 'bolsa de monedas encantadas'),
(6, 'bolsita de semillas'),
(30, 'botas ligeras'),
(25, 'cadena rota'),
(3, 'capa de hollín'),
(38, 'capa de tinieblas'),
(10, 'cinturón de cuero'),
(8, 'collar de viento'),
(36, 'delantal encantado'),
(16, 'diadema de algas'),
(35, 'escoba pequeña'),
(17, 'escudo rúnico'),
(27, 'esfera solar'),
(33, 'espada diminuta'),
(15, 'frasco de agua pura'),
(19, 'frasco de rocío'),
(4, 'gema lunar'),
(24, 'hojas encantadas'),
(5, 'hoz de cobre'),
(11, 'linterna solar'),
(12, 'manto brillante'),
(29, 'mapa encantado'),
(9, 'martillo encantado'),
(22, 'martillo sagrado'),
(39, 'moneda dorada'),
(14, 'monedas ilusorias'),
(13, 'nariz falsa'),
(26, 'ojo de cristal'),
(31, 'orbe de visión'),
(20, 'piedra curativa'),
(28, 'pulsera de cobre'),
(23, 'ramita de roble'),
(32, 'runas antiguas'),
(1, 'sombrero de trébol'),
(40, 'trébol de cinco hojas'),
(21, 'yunque miniatura');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blogs`
--

CREATE TABLE `blogs` (
  `id_blog` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `autor` varchar(120) DEFAULT NULL,
  `fecha_publicacion` date DEFAULT NULL,
  `categoria` varchar(80) DEFAULT NULL,
  `imagen_portada` varchar(255) DEFAULT NULL,
  `descripcion_corta` varchar(300) DEFAULT NULL,
  `contenido` mediumtext DEFAULT NULL,
  `popularidad` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `blogs`
--

INSERT INTO `blogs` (`id_blog`, `titulo`, `slug`, `autor`, `fecha_publicacion`, `categoria`, `imagen_portada`, `descripcion_corta`, `contenido`, `popularidad`) VALUES
(1, 'El origen secreto de los duendes irlandeses', 'origen-de-los-duendes-irlandeses', 'Maeve Ó Riordan', '2025-09-12', 'mitologia', 'https://misticshop.com/blogs/origen_duendes.png', 'Descubrí cómo los antiguos espíritus del bosque dieron origen a los duendes modernos que hoy traen fortuna o caos.', '<p>En los relatos más antiguos del folclore irlandés, los duendes eran guardianes del oro oculto...</p><p>Con el paso de los siglos, su figura se mezcló con la del artesano, el guardián de la suerte y el embaucador.</p>', 87),
(2, 'Rituales de la suerte con tréboles y monedas encantadas', 'rituales-de-la-suerte', 'Finn O’Malley', '2025-09-25', 'rituales', 'https://misticshop.com/blogs/rituales_suerte.png', 'Aprendé los rituales más antiguos de la Isla Esmeralda para atraer buena fortuna y energías doradas.', '<p>En el norte de Irlanda, los antiguos druidas realizaban rituales con tréboles de tres hojas...</p><p>Hoy podés replicarlos en tu hogar con elementos simples y un toque de intención mágica.</p>', 91),
(3, 'Cómo cuidar a tu duende místico en casa', 'cuidado-de-tu-duende', 'Brigid Flynn', '2025-10-03', 'guia-practica', 'https://misticshop.com/blogs/cuidado_duende.png', 'Los duendes necesitan respeto, espacio y, sobre todo, no ser ignorados. Aquí te contamos cómo mantener su energía equilibrada.', '<ul><li>Ubicalo cerca de la entrada principal.</li><li>No le cambies de lugar durante la luna nueva.</li><li>Ofrécele algo dorado los domingos.</li></ul>', 94),
(4, 'La alquimia detrás de los amuletos irlandeses', 'alquimia-de-amuletos', 'Declan Murphy', '2025-08-30', 'arte-magico', 'https://misticshop.com/blogs/amuletos_irlandeses.png', 'Los amuletos irlandeses combinan metalurgia ancestral con hechizos de protección. Descubrí cómo nacen las joyas con alma.', '<p>Los duendes herreros forjan cada pieza con precisión y fuego sagrado...</p><p>El secreto está en el equilibrio entre intención y material: oro, cobre y piedra lunar.</p>', 88);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_etiquetas`
--

CREATE TABLE `blog_etiquetas` (
  `id_blog` int(10) UNSIGNED NOT NULL,
  `id_etiqueta` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `blog_etiquetas`
--

INSERT INTO `blog_etiquetas` (`id_blog`, `id_etiqueta`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 4),
(2, 5),
(2, 6),
(3, 7),
(3, 8),
(3, 9),
(4, 10),
(4, 11),
(4, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_relaciones`
--

CREATE TABLE `blog_relaciones` (
  `id_blog` int(10) UNSIGNED NOT NULL,
  `id_blog_recomendado` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `blog_relaciones`
--

INSERT INTO `blog_relaciones` (`id_blog`, `id_blog_recomendado`) VALUES
(2, 1),
(3, 2),
(4, 1),
(4, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritos`
--

CREATE TABLE `carritos` (
  `id_carrito` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED DEFAULT NULL,
  `estado` enum('activo','pendiente','convertido','cancelado') NOT NULL DEFAULT 'activo',
  `creado_en` datetime NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `carritos`
--

INSERT INTO `carritos` (`id_carrito`, `id_usuario`, `estado`, `creado_en`, `actualizado_en`) VALUES
(1, 4, 'convertido', '2025-11-11 01:51:38', '2025-11-11 18:09:25'),
(2, 4, 'convertido', '2025-11-11 18:09:38', '2025-11-11 18:24:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_items`
--

CREATE TABLE `carrito_items` (
  `id_carrito` int(10) UNSIGNED NOT NULL,
  `id_duende` int(10) UNSIGNED NOT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `carrito_items`
--

INSERT INTO `carrito_items` (`id_carrito`, `id_duende`, `cantidad`, `precio_unitario`) VALUES
(1, 20, 1, 175.00),
(2, 20, 1, 175.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id_contacto` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `asunto` varchar(150) DEFAULT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` datetime NOT NULL DEFAULT current_timestamp(),
  `leido` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `duendes`
--

CREATE TABLE `duendes` (
  `id_duende` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `color_principal` varchar(60) DEFAULT NULL,
  `altura_cm` decimal(5,2) DEFAULT NULL,
  `personalidad` varchar(255) DEFAULT NULL,
  `id_rareza` tinyint(3) UNSIGNED DEFAULT NULL,
  `precio_en_oro` decimal(10,2) DEFAULT NULL,
  `efecto_magico` text DEFAULT NULL,
  `id_elemento` tinyint(3) UNSIGNED DEFAULT NULL,
  `nivel_maldad` tinyint(3) UNSIGNED DEFAULT NULL,
  `nivel_suerte` tinyint(3) UNSIGNED DEFAULT NULL,
  `origen_mitologico` varchar(150) DEFAULT NULL,
  `id_material` smallint(5) UNSIGNED DEFAULT NULL,
  `disponible` tinyint(1) DEFAULT 1,
  `fecha_creacion` date DEFAULT NULL,
  `popularidad` tinyint(3) UNSIGNED DEFAULT NULL,
  `recomendado_para` varchar(150) DEFAULT NULL,
  `advertencias` varchar(255) DEFAULT NULL,
  `imagen_url` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `duendes`
--

INSERT INTO `duendes` (`id_duende`, `nombre`, `tipo`, `color_principal`, `altura_cm`, `personalidad`, `id_rareza`, `precio_en_oro`, `efecto_magico`, `id_elemento`, `nivel_maldad`, `nivel_suerte`, `origen_mitologico`, `id_material`, `disponible`, `fecha_creacion`, `popularidad`, `recomendado_para`, `advertencias`, `imagen_url`, `descripcion`) VALUES
(1, 'Finn el Tramposo', 'duende del oro', 'verde esmeralda', 32.00, 'astuto y amante de las apuestas', 3, 120.50, 'atrae riqueza inesperada pero genera pequeños enredos financieros', 1, 4, 9, 'Colinas de Tara', 1, 1, '2025-10-06', 89, 'atraer fortuna', 'No apostar contra él durante luna nueva', 'uploads/duendes/finn-el-tramposo-6914b23b6a5f67.33029018.png', 'Finn es famoso entre los duendes por su sonrisa torcida y su habilidad para convertir un penique en fortuna... o en deuda. Quien lo posea verá dinero venir, pero también tentaciones. Ideal para quienes disfrutan del riesgo calculado.'),
(2, 'Morgra la Sombría', 'duende nocturno', 'negro carbón', 40.00, 'enigmática y silenciosa', 4, 320.00, 'otorga invisibilidad parcial durante la noche', 5, 7, 6, 'Bosques de Doolin', 2, 1, '2025-10-06', 94, 'proteger secretos', 'No pronunciar su nombre después del anochecer', 'uploads/duendes/morgra-la-sombr-ia-6914b1db756da6.35496345.png', 'Morgra camina entre las sombras y habla con los búhos. Guarda secretos antiguos y no teme al silencio. Ideal para quienes necesitan mantener su vida privada… literalmente invisible.'),
(3, 'Bram el Cosechador', 'duende del campo', 'marrón musgo', 45.00, 'trabajador y sereno', 1, 45.00, 'incrementa la fertilidad de los cultivos', 1, 1, 7, 'Tierras de Meath', 3, 1, '2025-10-06', 73, 'bendecir cosechas', 'Nunca dejarlo sin tierra bajo los pies', 'uploads/duendes/bram-el-cosechador-6914b30789cf43.00504609.png', 'Con olor a tierra húmeda y sonrisa de labrador, Bram bendice jardines y huertas. Si le ofrecés pan recién horneado, susurra fórmulas que hacen florecer hasta las piedras.'),
(4, 'Lira Danzarina', 'duende de la música', 'azul zafiro', 27.00, 'alegre y melodiosa', 2, 80.30, 'atrae alegría y elimina tensiones del hogar', 4, 2, 8, 'Cliffs of Moher', 4, 1, '2025-10-06', 92, 'armonizar ambientes', 'Evitar el silencio total, puede desaparecer', 'uploads/duendes/lira-danzarina-6914b1f3c09191.47340670.png', 'Su música no se oye con los oídos, sino con el alma. Lira toca acordes invisibles que limpian el aire de discusiones y traen risas a las cocinas.'),
(5, 'Doran el Zapatero', 'duende artesano', 'verde olivo', 38.00, 'preciso y gruñón', 1, 55.20, 'fortalece los negocios artesanales y manuales', 1, 3, 6, 'Cork', 5, 1, '2025-10-06', 68, 'artesanos y emprendedores', 'Nunca tocar sus herramientas sin permiso', 'uploads/duendes/doran-el-zapatero-6914b315d4d5e3.42514986.png', 'Doran trabaja toda la noche creando cosas pequeñas y perfectas. Si lo tratás bien, mejorará tu habilidad para fabricar o vender. Si no, tus cordones se anudarán solos.'),
(6, 'Eithne la Luminosa', 'duende de la luz', 'dorado', 29.00, 'compasiva y radiante', 4, 310.00, 'purifica el ambiente y ahuyenta energías negativas', 6, 1, 10, 'Valle de Glendalough', 1, 1, '2025-10-06', 98, 'hogares con energía pesada', 'No dejarla en lugares oscuros por largos periodos', 'uploads/duendes/eithne-la-luminosa-6914b0bac733a1.87856195.png', 'Eithne emite una luz suave incluso cuando duerme. Su sola presencia aclara pensamientos y repele la tristeza. Colocarla cerca de una ventana potencia su efecto.'),
(7, 'Seamus el Burlón', 'duende bromista', 'verde lima', 35.00, 'travieso y parlanchín', 2, 75.80, 'causa confusión divertida en reuniones', 4, 6, 5, 'Dublín', 1, 1, '2025-10-06', 84, 'fiestas y eventos', 'Puede esconder tus llaves', 'uploads/duendes/seamus-el-burl-on-6914b2b5f33577.47730308.png', 'Donde Seamus aparece, nadie se aburre. Provoca risas, confusiones y algún que otro tropiezo cómico. Perfecto para animar celebraciones o desarmar tensiones laborales.'),
(8, 'Nuala del Arroyo', 'duende acuático', 'turquesa', 28.00, 'serena y reflexiva', 3, 150.00, 'limpia las emociones y atrae claridad mental', 2, 1, 9, 'Río Shannon', 1, 1, '2025-10-06', 90, 'sanación emocional', 'No mantenerla lejos de fuentes de agua', 'uploads/duendes/nuala-del-arroyo-6914b21e8c6756.10470759.png', 'Susurra como el agua sobre piedras. Nuala trae calma a la mente inquieta y limpia el aire emocional. Un vaso de agua junto a ella amplifica su poder.'),
(9, 'Tadhg el Guardián', 'duende protector', 'gris piedra', 50.00, 'firme y silencioso', 3, 200.00, 'protege el hogar de intrusos y malos espíritus', 1, 1, 8, 'Castillo de Blarney', 1, 1, '2025-10-06', 87, 'protección del hogar', 'Debe colocarse mirando la entrada principal', 'uploads/duendes/tadhg-el-guardi-an-6914b260024fa2.24509394.png', 'Inmóvil pero vigilante, Tadhg percibe intenciones ajenas. Se dice que quien lo mire a los ojos siente una calma protectora. Colócalo frente a la puerta principal para máxima defensa.'),
(10, 'Brigid la Curandera', 'duende sanadora', 'blanco perlado', 26.00, 'tranquila y maternal', 3, 185.70, 'mejora el descanso y la energía vital', 2, 1, 10, 'Lago Corrib', 1, 1, '2025-10-06', 95, 'salud y equilibrio emocional', 'No exponer a luz directa durante eclipses', 'uploads/duendes/brigid-la-curandera-6914b145ab3f19.93470609.png', 'Brigid destila paz. Su presencia suaviza los sueños y equilibra el cuerpo. Ideal para colocar en dormitorios o consultorios de sanación.'),
(11, 'Cathal el Forjador', 'duende herrero', 'rojo cobre', 42.00, 'dedicado y fuerte', 2, 110.40, 'forja amuletos de poder y suerte duradera', 3, 2, 9, 'Montes Wicklow', 1, 1, '2025-10-06', 82, 'reforzar amuletos', 'No tocarlo con manos mojadas', 'uploads/duendes/cathal-el-forjador-6914b2dc2e9a83.48202035.png', 'Entre chispas diminutas, Cathal da forma a la suerte. Quienes trabajan con metales o herramientas sienten su inspiración al alcance de la mano.'),
(12, 'Aoife la Verde', 'duende del bosque', 'verde bosque', 30.00, 'pacífica y protectora de la naturaleza', 2, 95.00, 'atrae armonía ecológica y prosperidad natural', 1, 1, 8, 'Bosque de Killarney', 1, 1, '2025-10-06', 91, 'protección ambiental', 'No separarla de plantas vivas', 'uploads/duendes/aoife-la-verde-6914b20c634e94.96200217.png', 'Los pájaros parecen cantar más cerca cuando Aoife está presente. Su energía reverdece ambientes y estimula la conexión con la naturaleza.'),
(13, 'Declan el Burlado', 'duende maldito', 'gris plomo', 33.00, 'resentido pero leal', 3, 155.00, 'convierte desgracias en aprendizajes valiosos', 5, 5, 7, 'Ruinas de Cashel', 1, 1, '2025-10-06', 79, 'superar malas rachas', 'Nunca burlarse de su pasado', 'uploads/duendes/declan-el-burlado-6914b2eea24c09.11490174.png', 'Declan fue traicionado hace siglos y aún carga con su historia. Acompaña a quienes aprenden del dolor, transformando cicatrices en fortaleza.'),
(14, 'Sorcha la Centelleante', 'duende solar', 'naranja brillante', 25.00, 'optimista y vivaz', 3, 165.30, 'potencia la creatividad y el entusiasmo', 3, 1, 9, 'Montes Slieve Bloom', 1, 1, '2025-10-06', 97, 'creadores y artistas', 'No exponer a lluvias prolongadas', 'uploads/duendes/sorcha-la-centelleante-6914b0d2eb7325.66164370.png', 'Donde Sorcha pasa, la inspiración florece. Irradia entusiasmo y luz cálida. Perfecta para talleres, estudios o espacios de creación.'),
(15, 'Ruairí el Errante', 'duende viajero', 'azul marino', 37.00, 'curioso y aventurero', 2, 105.00, 'protege a los viajeros de accidentes y pérdidas', 4, 2, 9, 'Isla Achill', 1, 1, '2025-10-06', 85, 'viajeros frecuentes', 'Debe guardarse en bolsos de viaje', 'uploads/duendes/ruair-i-el-errante-6914b2a267d9e1.78858590.png', 'Amante del movimiento, Ruairí trae buena estrella en rutas largas. Protege maletas, evita desvíos y asegura regresos con historias nuevas.'),
(16, 'Maeve la de los Susurros', 'duende oracular', 'violeta oscuro', 31.00, 'misteriosa y sabia', 4, 350.00, 'revela señales ocultas y guía decisiones', 5, 3, 10, 'Cuevas de Knocknarea', 1, 1, '2025-10-06', 99, 'lecturas y adivinación', 'No interrumpir sus visiones', 'uploads/duendes/maeve-la-de-los-susurros-6914b06db5df22.61766748.png', 'Maeve habla en sueños y murmullos. Si la escuchás con calma, puede revelar lo que aún no sabés que sabés. Ideal para tarotistas y buscadores del destino.'),
(17, 'Padraig el Rojo', 'duende guerrero', 'rojo escarlata', 48.00, 'valiente y feroz', 3, 210.00, 'infunde coraje y fuerza ante desafíos', 3, 2, 8, 'Montes Mourne', 1, 1, '2025-10-06', 88, 'personas con nuevos comienzos', 'Evitar provocarlo en discusiones', 'uploads/duendes/padraig-el-rojo-6914b24e4940e5.14394643.png', 'Guardián de los valientes, Padraig brinda impulso a quienes dudan. Su espíritu guerrero fortalece la voluntad y aleja los miedos.'),
(18, 'Ciara la Dulce', 'duende doméstica', 'rosa pastel', 22.00, 'dulce y colaborativa', 1, 40.00, 'atrae armonía y unión familiar', 6, 1, 9, 'Casas de Donegal', 1, 1, '2025-10-06', 83, 'hogares y parejas', 'No dejarla sin tareas domésticas', 'uploads/duendes/ciara-la-dulce-6914b2c8e54a41.91032676.png', 'Ciara ordena más que casas: ordena corazones. Su dulzura suaviza las discusiones y fomenta la cooperación. Ideal para familias con niños o mascotas.'),
(19, 'Aedan el Oscuro', 'duende vengativo', 'negro azabache', 44.00, 'rencoroso y serio', 4, 280.00, 'devuelve el mal a quien lo envía', 5, 8, 6, 'Abadía de Clonmacnoise', 1, 1, '2025-10-06', 86, 'protección contra maldiciones', 'No usar con fines egoístas', 'uploads/duendes/aedan-el-oscuro-6914b274da9968.09225858.png', 'Aedan observa desde las sombras y equilibra la balanza. Su justicia es implacable: quien daña, recibe lo propio. Protector ideal para quienes enfrentan envidias o traiciones.'),
(20, 'Oisín el Alegre', 'duende de la fortuna', 'verde brillante', 33.00, 'optimista y generoso', 3, 175.00, 'atrae oportunidades y buena suerte constante', 6, 1, 10, 'Praderas de Louth', 1, 1, '2025-10-06', 100, 'nuevos comienzos y negocios', 'Nunca prometerle algo y no cumplirlo', 'uploads/duendes/ois-in-el-alegre-6914b0520aed09.23440228.png', 'Oisín sonríe incluso bajo la lluvia. Lleva consigo la suerte pura de Irlanda. Ideal para quienes inician proyectos, negocios o aventuras de vida.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `duende_accesorios`
--

CREATE TABLE `duende_accesorios` (
  `id_duende` int(10) UNSIGNED NOT NULL,
  `id_accesorio` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `duende_accesorios`
--

INSERT INTO `duende_accesorios` (`id_duende`, `id_accesorio`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(3, 5),
(3, 6),
(4, 7),
(4, 8),
(5, 9),
(5, 10),
(6, 11),
(6, 12),
(7, 13),
(7, 14),
(8, 15),
(8, 16),
(9, 17),
(9, 18),
(10, 19),
(10, 20),
(11, 21),
(11, 22),
(12, 23),
(12, 24),
(13, 25),
(13, 26),
(14, 27),
(14, 28),
(15, 29),
(15, 30),
(16, 31),
(16, 32),
(17, 33),
(17, 34),
(18, 35),
(18, 36),
(19, 37),
(19, 38),
(20, 39),
(20, 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elementos`
--

CREATE TABLE `elementos` (
  `id_elemento` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `elementos`
--

INSERT INTO `elementos` (`id_elemento`, `nombre`) VALUES
(2, 'agua'),
(4, 'aire'),
(3, 'fuego'),
(6, 'luz'),
(5, 'sombra'),
(1, 'tierra');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas`
--

CREATE TABLE `etiquetas` (
  `id_etiqueta` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `etiquetas`
--

INSERT INTO `etiquetas` (`id_etiqueta`, `nombre`) VALUES
(5, 'amuletos'),
(10, 'artesania'),
(12, 'duendes-artesanos'),
(8, 'espiritualidad'),
(2, 'folklore'),
(1, 'historia celta'),
(7, 'hogar'),
(3, 'irlanda antigua'),
(6, 'magia blanca'),
(11, 'metalurgia'),
(9, 'proteccion'),
(4, 'suerte');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id_material` smallint(5) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `materiales`
--

INSERT INTO `materiales` (`id_material`, `nombre`) VALUES
(13, 'acero oscuro'),
(7, 'arcilla encantada'),
(17, 'bronce celta'),
(19, 'ceniza mágica'),
(6, 'cristal bendecido'),
(10, 'cristal de cuarzo'),
(14, 'cristal ígneo'),
(4, 'cristal sonoro'),
(15, 'cuero de hada'),
(1, 'cuero encantado'),
(11, 'hierro celta'),
(5, 'madera de fresno'),
(3, 'madera de roble'),
(12, 'madera viva'),
(16, 'obsidiana pulida'),
(20, 'oro encantado'),
(8, 'perla de río'),
(9, 'piedra lunar'),
(2, 'piedra volcánica'),
(18, 'tela bendecida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','procesando','enviado','completado','cancelado') NOT NULL DEFAULT 'pendiente',
  `fecha_pedido` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_usuario`, `total`, `estado`, `fecha_pedido`) VALUES
(1, 4, 175.00, 'cancelado', '2025-11-11 01:51:43'),
(2, 4, 175.00, 'enviado', '2025-11-11 18:24:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_items`
--

CREATE TABLE `pedido_items` (
  `id_pedido` int(10) UNSIGNED NOT NULL,
  `id_duende` int(10) UNSIGNED NOT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedido_items`
--

INSERT INTO `pedido_items` (`id_pedido`, `id_duende`, `cantidad`, `precio_unitario`) VALUES
(1, 20, 1, 175.00),
(2, 20, 1, 175.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rareza`
--

CREATE TABLE `rareza` (
  `id_rareza` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rareza`
--

INSERT INTO `rareza` (`id_rareza`, `nombre`) VALUES
(1, 'común'),
(3, 'épico'),
(4, 'legendario'),
(2, 'raro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secciones`
--

CREATE TABLE `secciones` (
  `id_seccion` int(10) UNSIGNED NOT NULL,
  `vinculo` varchar(80) NOT NULL,
  `titulo` varchar(120) NOT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `menu` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `secciones`
--

INSERT INTO `secciones` (`id_seccion`, `vinculo`, `titulo`, `descripcion`, `menu`) VALUES
(1, 'inicio', 'Inicio', 'Sección principal con bienvenida, llamado a la acción y elementos mágicos animados.', 1),
(2, 'catalogo', 'Catálogo de Duendes', 'Galería completa de duendes con filtros por rareza, afinidad, suerte o propósito.', 1),
(3, 'detalle_producto', 'Ficha del Duende', 'Vista individual de cada duende con su descripción, atributos, historia y accesorios.', 0),
(4, 'nosotros', 'Sobre la Tienda', 'Historia, misión y el mito detrás de los duendes que vendemos.', 1),
(5, 'blog', 'Crónicas del Bosque', 'Artículos sobre mitología celta, rituales de suerte, leyendas y cuvinculoado de duendes.', 1),
(6, 'detalle_blog', 'Artículo del Blog', 'Vista individual de cada artículo del blog con su contenido, imágenes y comentarios.', 0),
(7, 'contacto', 'Contacto y Bendiciones', 'Formulario para consultas, colaboraciones o adopciones mágicas personalizadas.', 1),
(8, 'carrito', 'Carrito Mágico', 'Resumen de los duendes seleccionados, con cálculo automático en monedas de oro.', 0),
(9, 'checkout', 'Finalizar Compra', 'Página de confirmación donde se elige el método de envío y pago.', 0),
(10, 'cuenta', 'Mi Cuenta', 'Zona del usuario con historial de compras, deseos y configuraciones.', 0),
(11, 'login', 'Ingresar', 'Página de inicio de sesión para usuarios registrados.', 0),
(12, 'registro', 'Registrarse', 'Formulario de registro para nuevos usuarios.', 0),
(13, 'logout', 'Cerrar Sesión', 'Acción para cerrar la sesión del usuario.', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secciones_admin`
--

CREATE TABLE `secciones_admin` (
  `id_seccion_admin` int(10) UNSIGNED NOT NULL,
  `vinculo` varchar(80) NOT NULL,
  `titulo` varchar(120) NOT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `menu` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `secciones_admin`
--

INSERT INTO `secciones_admin` (`id_seccion_admin`, `vinculo`, `titulo`, `descripcion`, `menu`) VALUES
(1, 'inicio', 'Inicio', 'Sección principal del panel administrativo con resumen general.', 1),
(2, 'catalogo', 'Gestión de Duendes', 'Catálogo completo de duendes, permite alta, baja y modificación.', 1),
(3, 'detalle_producto', 'Detalle del Duende', 'Vista individual con información y atributos mágicos.', 0),
(5, 'blog', 'Gestión de Blogs', 'Creación y edición de artículos del blog.', 1),
(6, 'detalle_blog', 'Detalle de Blog', 'Vista interna para edición o revisión de artículos.', 0),
(7, 'contacto', 'Consultas & Mensajes', 'Gestión de contactos o mensajes recibidos.', 1),
(8, 'carrito', 'Gestión de Carritos', 'Revisión de carritos activos o abandonados.', 0),
(9, 'checkout', 'Pedidos Confirmados', 'Visualización de pedidos y estados de pago/envío.', 0),
(10, 'cuenta', 'Usuarios & Cuentas', 'Administración de cuentas registradas y permisos.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `rol` enum('usuario','admin') NOT NULL DEFAULT 'usuario',
  `fecha_alta` datetime NOT NULL DEFAULT current_timestamp(),
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `email`, `password_hash`, `rol`, `fecha_alta`, `activo`) VALUES
(3, 'Administrador', NULL, 'admin@tienda.com', '$2y$10$DE3czMIHcT4rmvDDyoTN6O/LxvKKRCcVy9uhgWaHX4UiMJfZ4s9NG', 'admin', '2025-11-11 01:34:09', 1),
(4, 'Usuario Prueba', NULL, 'usuario@test.com', '$2y$10$Oj8pBhllD.2rQhD8J2hU6uCDyyud9da0f.oXthbe4PXxuWmkpc.aK', 'usuario', '2025-11-11 01:34:09', 1),
(5, 'Jorge', NULL, 'jorge@tienda.com', '$2y$10$cZ3ZazQ9NdF/TvGiXZba8.4/mi4P5TYabIP2hpzDVtIXOVZ.1VKxa', 'usuario', '2025-11-11 19:44:26', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accesorios`
--
ALTER TABLE `accesorios`
  ADD PRIMARY KEY (`id_accesorio`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id_blog`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_blogs_fecha` (`fecha_publicacion`),
  ADD KEY `idx_blogs_categoria` (`categoria`),
  ADD KEY `idx_blogs_popularidad` (`popularidad`);

--
-- Indices de la tabla `blog_etiquetas`
--
ALTER TABLE `blog_etiquetas`
  ADD PRIMARY KEY (`id_blog`,`id_etiqueta`),
  ADD KEY `fk_be_etiqueta` (`id_etiqueta`);

--
-- Indices de la tabla `blog_relaciones`
--
ALTER TABLE `blog_relaciones`
  ADD PRIMARY KEY (`id_blog`,`id_blog_recomendado`),
  ADD KEY `fk_br_blog_r` (`id_blog_recomendado`);

--
-- Indices de la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `fk_carrito_usuario` (`id_usuario`);

--
-- Indices de la tabla `carrito_items`
--
ALTER TABLE `carrito_items`
  ADD PRIMARY KEY (`id_carrito`,`id_duende`),
  ADD KEY `fk_ci_duende` (`id_duende`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id_contacto`);

--
-- Indices de la tabla `duendes`
--
ALTER TABLE `duendes`
  ADD PRIMARY KEY (`id_duende`),
  ADD KEY `fk_duendes_material` (`id_material`),
  ADD KEY `idx_duendes_rareza` (`id_rareza`),
  ADD KEY `idx_duendes_elemento` (`id_elemento`),
  ADD KEY `idx_duendes_disponible` (`disponible`),
  ADD KEY `idx_duendes_popularidad` (`popularidad`),
  ADD KEY `idx_duendes_suerte_maldad` (`nivel_suerte`,`nivel_maldad`);

--
-- Indices de la tabla `duende_accesorios`
--
ALTER TABLE `duende_accesorios`
  ADD PRIMARY KEY (`id_duende`,`id_accesorio`),
  ADD KEY `fk_da_accesorio` (`id_accesorio`);

--
-- Indices de la tabla `elementos`
--
ALTER TABLE `elementos`
  ADD PRIMARY KEY (`id_elemento`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  ADD PRIMARY KEY (`id_etiqueta`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id_material`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_pedido_usuario` (`id_usuario`);

--
-- Indices de la tabla `pedido_items`
--
ALTER TABLE `pedido_items`
  ADD PRIMARY KEY (`id_pedido`,`id_duende`),
  ADD KEY `fk_pi_duende` (`id_duende`);

--
-- Indices de la tabla `rareza`
--
ALTER TABLE `rareza`
  ADD PRIMARY KEY (`id_rareza`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `secciones`
--
ALTER TABLE `secciones`
  ADD PRIMARY KEY (`id_seccion`),
  ADD UNIQUE KEY `vinculo` (`vinculo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `ux_usuarios_email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accesorios`
--
ALTER TABLE `accesorios`
  MODIFY `id_accesorio` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id_blog` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `carritos`
--
ALTER TABLE `carritos`
  MODIFY `id_carrito` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id_contacto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `duendes`
--
ALTER TABLE `duendes`
  MODIFY `id_duende` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `elementos`
--
ALTER TABLE `elementos`
  MODIFY `id_elemento` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  MODIFY `id_etiqueta` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id_material` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rareza`
--
ALTER TABLE `rareza`
  MODIFY `id_rareza` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `secciones`
--
ALTER TABLE `secciones`
  MODIFY `id_seccion` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `blog_etiquetas`
--
ALTER TABLE `blog_etiquetas`
  ADD CONSTRAINT `fk_be_blog` FOREIGN KEY (`id_blog`) REFERENCES `blogs` (`id_blog`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_be_etiqueta` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiquetas` (`id_etiqueta`) ON DELETE CASCADE;

--
-- Filtros para la tabla `blog_relaciones`
--
ALTER TABLE `blog_relaciones`
  ADD CONSTRAINT `fk_br_blog` FOREIGN KEY (`id_blog`) REFERENCES `blogs` (`id_blog`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_br_blog_r` FOREIGN KEY (`id_blog_recomendado`) REFERENCES `blogs` (`id_blog`) ON DELETE CASCADE;

--
-- Filtros para la tabla `duendes`
--
ALTER TABLE `duendes`
  ADD CONSTRAINT `fk_duendes_elemento` FOREIGN KEY (`id_elemento`) REFERENCES `elementos` (`id_elemento`),
  ADD CONSTRAINT `fk_duendes_material` FOREIGN KEY (`id_material`) REFERENCES `materiales` (`id_material`),
  ADD CONSTRAINT `fk_duendes_rareza` FOREIGN KEY (`id_rareza`) REFERENCES `rareza` (`id_rareza`);

--
-- Filtros para la tabla `duende_accesorios`
--
ALTER TABLE `duende_accesorios`
  ADD CONSTRAINT `fk_da_accesorio` FOREIGN KEY (`id_accesorio`) REFERENCES `accesorios` (`id_accesorio`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_da_duende` FOREIGN KEY (`id_duende`) REFERENCES `duendes` (`id_duende`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
