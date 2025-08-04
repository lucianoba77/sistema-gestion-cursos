SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
CREATE TABLE `alumnos` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci,
  `genero` enum('masculino','femenino','otro') COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `alumnos` (`id`, `nombre`, `apellido`, `dni`, `email`, `fecha_nacimiento`, `telefono`, `direccion`, `genero`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Sofía', 'González', '11111111', 'sofia.gonzalez@email.com', '2000-05-15', '011-1111-1111', 'Av. Santa Fe 100, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(2, 'Lucas', 'Rodríguez', '11111112', 'lucas.rodriguez@email.com', '1999-08-22', '011-1111-1112', 'Corrientes 200, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(3, 'Valentina', 'Fernández', '11111113', 'valentina.fernandez@email.com', '2001-03-10', '011-1111-1113', 'Belgrano 300, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(4, 'Mateo', 'López', '11111114', 'mateo.lopez@email.com', '1998-12-05', '011-1111-1114', 'Palermo 400, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(5, 'Isabella', 'Martínez', '11111115', 'isabella.martinez@email.com', '2002-07-18', '011-1111-1115', 'Recoleta 500, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(6, 'Santiago', 'García', '11111116', 'santiago.garcia@email.com', '1997-11-30', '011-1111-1116', 'San Telmo 600, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(7, 'Camila', 'Pérez', '11111117', 'camila.perez@email.com', '2000-01-25', '011-1111-1117', 'Villa Crespo 700, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(8, 'Nicolás', 'Gómez', '11111118', 'nicolas.gomez@email.com', '1999-06-12', '011-1111-1118', 'Caballito 800, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(9, 'Lucía', 'Díaz', '11111119', 'lucia.diaz@email.com', '2001-09-08', '011-1111-1119', 'Almagro 900, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(10, 'Alejandro', 'Torres', '11111120', 'alejandro.torres@email.com', '1998-04-14', '011-1111-1120', 'Boedo 1000, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(11, 'Mariana', 'Ruiz', '11111121', 'mariana.ruiz@email.com', '2000-02-28', '011-1111-1121', 'Flores 1100, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(12, 'Diego', 'Herrera', '11111122', 'diego.herrera@email.com', '1999-10-17', '011-1111-1122', 'Parque Patricios 1200, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(13, 'Gabriela', 'Jiménez', '11111123', 'gabriela.jimenez@email.com', '2001-12-03', '011-1111-1123', 'Villa Lugano 1300, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(14, 'Federico', 'Moreno', '11111124', 'federico.moreno@email.com', '1998-07-20', '011-1111-1124', 'Villa Riachuelo 1400, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(15, 'Daniela', 'Morales', '11111125', 'daniela.morales@email.com', '2000-11-11', '011-1111-1125', 'Villa Soldati 1500, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(16, 'Roberto', 'Castro', '11111126', 'roberto.castro@email.com', '1997-05-09', '011-1111-1126', 'Villa Devoto 1600, CABA', 'masculino', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(17, 'Carmen', 'Vargas', '11111127', 'carmen.vargas@email.com', '1999-08-31', '011-1111-1127', 'Villa del Parque 1700, CABA', 'femenino', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(18, 'Héctor', 'Reyes', '11111128', 'hector.reyes@email.com', '1998-03-16', '011-1111-1128', 'Villa General Mitre 1800, CABA', 'masculino', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(19, 'Patricia', 'Cruz', '11111129', 'patricia.cruz@email.com', '2000-06-24', '011-1111-1129', 'Villa Santa Rita 1900, CABA', 'femenino', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(20, 'Ricardo', 'Flores', '11111130', 'ricardo.flores@email.com', '1997-12-07', '011-1111-1130', 'Villa Pueyrredón 2000, CABA', 'masculino', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(21, 'Elena', 'Ramos', '11111131', 'elena.ramos@email.com', '2001-01-19', '011-1111-1131', 'Villa Urquiza 2100, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(22, 'Javier', 'Acosta', '11111132', 'javier.acosta@email.com', '1999-04-13', '011-1111-1132', 'Villa Ortúzar 2200, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(23, 'Verónica', 'Medina', '11111133', 'veronica.medina@email.com', '2000-09-26', '011-1111-1133', 'Chacarita 2300, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(24, 'Gustavo', 'Aguilar', '11111134', 'gustavo.aguilar@email.com', '1998-02-08', '011-1111-1134', 'Colegiales 2400, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(25, 'Natalia', 'Vega', '11111135', 'natalia.vega@email.com', '2001-07-15', '011-1111-1135', 'Nuñez 2500, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(26, 'Fernando', 'Mendoza', '11111136', 'fernando.mendoza@email.com', '1999-11-02', '011-1111-1136', 'Saavedra 2600, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(27, 'Adriana', 'Guerrero', '11111137', 'adriana.guerrero@email.com', '2000-03-29', '011-1111-1137', 'Coghlan 2700, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(28, 'Mauricio', 'Luna', '11111138', 'mauricio.luna@email.com', '1998-08-06', '011-1111-1138', 'Villa Martelli 2800, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(29, 'Silvia', 'Ríos', '11111139', 'silvia.rios@email.com', '2001-05-21', '011-1111-1139', 'Munro 2900, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(30, 'Pablo', 'Blanco', '11111140', 'pablo.blanco@email.com', '1997-10-14', '011-1111-1140', 'Vicente López 3000, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(31, 'Carolina', 'Navarro', '11111141', 'carolina.navarro@email.com', '2000-12-18', '011-1111-1141', 'San Isidro 3100, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(32, 'Leonardo', 'Miranda', '11111142', 'leonardo.miranda@email.com', '1999-06-25', '011-1111-1142', 'Tigre 3200, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(33, 'Rocío', 'Cortés', '11111143', 'rocio.cortes@email.com', '2001-02-11', '011-1111-1143', 'San Fernando 3300, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(34, 'Eduardo', 'Ortega', '11111144', 'eduardo.ortega@email.com', '1998-07-04', '011-1111-1144', 'Escobar 3400, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(35, 'Mónica', 'Soto', '11111145', 'monica.soto@email.com', '2000-01-30', '011-1111-1145', 'Pilar 3500, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(36, 'Alex', 'Rivera', '11111146', 'alex.rivera@email.com', '1999-09-12', '011-1111-1146', 'Malvinas Argentinas 3600, CABA', 'otro', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(37, 'Sam', 'Valdez', '11111147', 'sam.valdez@email.com', '2001-04-08', '011-1111-1147', 'José C. Paz 3700, CABA', 'otro', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(38, 'Jordan', 'Campos', '11111148', 'jordan.campos@email.com', '1998-11-23', '011-1111-1148', 'San Miguel 3800, CABA', 'otro', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(39, 'Taylor', 'Salinas', '11111149', 'taylor.salinas@email.com', '2000-08-17', '011-1111-1149', 'Moreno 3900, CABA', 'otro', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(40, 'Casey', 'Zúñiga', '11111150', 'casey.zuniga@email.com', '1997-12-05', '011-1111-1150', 'Merlo 4000, CABA', 'otro', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(41, 'Brenda', 'Paredes', '11111151', 'brenda.paredes@email.com', '2001-03-19', '011-1111-1151', 'Ituzaingó 4100, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(42, 'Cristian', 'Escobar', '11111152', 'cristian.escobar@email.com', '1999-10-28', '011-1111-1152', 'Hurlingham 4200, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(43, 'Diana', 'Fuentes', '11111153', 'diana.fuentes@email.com', '2000-05-16', '011-1111-1153', 'Morón 4300, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(44, 'Esteban', 'Ávila', '11111154', 'esteban.avila@email.com', '1998-01-09', '011-1111-1154', 'Castelar 4400, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(45, 'Fabiana', 'Molina', '11111155', 'fabiana.molina@email.com', '2001-07-22', '011-1111-1155', 'Haedo 4500, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(46, 'Gonzalo', 'Herrera', '11111156', 'gonzalo.herrera@email.com', '1997-12-14', '011-1111-1156', 'Ramos Mejía 4600, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(47, 'Helena', 'Lara', '11111157', 'helena.lara@email.com', '2000-06-03', '011-1111-1157', 'San Justo 4700, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(48, 'Ignacio', 'Espinoza', '11111158', 'ignacio.espinoza@email.com', '1999-02-27', '011-1111-1158', 'La Matanza 4800, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(49, 'Jazmín', 'Valencia', '11111159', 'jazmin.valencia@email.com', '2001-11-08', '011-1111-1159', 'Ezeiza 4900, CABA', 'femenino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(50, 'Kevin', 'Maldonado', '11111160', 'kevin.maldonado@email.com', '1998-04-12', '011-1111-1160', 'Esteban Echeverría 5000, CABA', 'masculino', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01');
CREATE TABLE `archivos_adjuntos` (
  `id` bigint UNSIGNED NOT NULL,
  `curso_id` bigint UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `archivo_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('tarea','material','guia') COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_subida` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `archivos_adjuntos` (`id`, `curso_id`, `titulo`, `archivo_url`, `tipo`, `fecha_subida`, `created_at`, `updated_at`) VALUES
(1, 1, 'Guía de Álgebra Lineal', '/archivos/guia-algebra-lineal.pdf', 'guia', '2024-03-05 13:00:00', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(2, 1, 'Ejercicios de Cálculo', '/archivos/ejercicios-calculo.pdf', 'material', '2024-03-10 17:00:00', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(3, 2, 'Antología de Borges', '/archivos/antologia-borges.pdf', 'material', '2024-03-20 12:00:00', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(4, 2, 'Tarea de Análisis Literario', '/archivos/tarea-analisis-literario.pdf', 'tarea', '2024-04-15 19:00:00', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(5, 3, 'Mapa de América Colonial', '/archivos/mapa-america-colonial.jpg', 'material', '2024-04-05 14:00:00', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(6, 4, 'Protocolo de Laboratorio', '/archivos/protocolo-laboratorio.pdf', 'guia', '2024-03-15 16:00:00', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(7, 5, 'Guía de Pronunciación', '/archivos/guia-pronunciacion.pdf', 'guia', '2024-03-25 18:00:00', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(8, 6, 'Manual de HTML y CSS', '/archivos/manual-html-css.pdf', 'material', '2024-04-20 13:00:00', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(9, 7, 'Textos de Filosofía Moderna', '/archivos/textos-filosofia-moderna.pdf', 'material', '2024-05-10 15:00:00', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(10, 8, 'Guía de Química Orgánica', '/archivos/guia-quimica-organica.pdf', 'guia', '2024-04-15 17:00:00', '2025-07-31 17:54:01', '2025-07-31 17:54:01');
CREATE TABLE `cursos` (
  `id` bigint UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` enum('activo','finalizado','cancelado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `modalidad` enum('presencial','virtual','hibrido') COLLATE utf8mb4_unicode_ci NOT NULL,
  `aula_virtual` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cupos_maximos` int NOT NULL DEFAULT '30',
  `docente_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `cursos` (`id`, `titulo`, `descripcion`, `fecha_inicio`, `fecha_fin`, `estado`, `modalidad`, `aula_virtual`, `cupos_maximos`, `docente_id`, `created_at`, `updated_at`) VALUES
(1, 'Matemáticas Avanzadas', 'Curso de matemáticas para nivel universitario', '2024-03-01', '2024-06-30', 'activo', 'presencial', NULL, 25, 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(2, 'Literatura Argentina Contemporánea', 'Análisis de obras literarias argentinas del siglo XX y XXI', '2024-03-15', '2024-06-30', 'activo', 'hibrido', 'https://meet.google.com/literatura-arg', 20, 2, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(3, 'Historia de América Latina', 'Estudio de la historia latinoamericana desde la colonización', '2024-04-01', '2024-07-31', 'activo', 'virtual', 'https://zoom.us/j/historia-latam', 30, 3, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(4, 'Biología Molecular', 'Fundamentos de biología molecular y genética', '2024-03-10', '2024-07-15', 'activo', 'presencial', NULL, 15, 4, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(5, 'Inglés Conversacional', 'Práctica de inglés hablado y comprensión auditiva', '2024-03-20', '2024-08-20', 'activo', 'hibrido', 'https://meet.google.com/ingles-conversacional', 35, 5, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(6, 'Programación Web', 'Desarrollo de aplicaciones web con HTML, CSS y JavaScript', '2024-04-15', '2024-08-30', 'finalizado', 'virtual', 'https://zoom.us/j/programacion-web', 40, 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(7, 'Filosofía Moderna', 'Estudio de los principales filósofos modernos', '2024-05-01', '2024-09-30', 'activo', 'presencial', NULL, 20, 2, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(8, 'Química Orgánica', 'Principios de química orgánica y sus aplicaciones', '2024-04-10', '2024-08-15', 'activo', 'hibrido', 'https://meet.google.com/quimica-organica', 25, 4, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(9, 'Arte Digital', 'Creación de arte utilizando herramientas digitales', '2024-05-15', '2024-09-30', 'activo', 'virtual', 'https://zoom.us/j/arte-digital', 30, 3, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(10, 'Psicología Social', 'Estudio de la interacción entre individuos y grupos', '2024-06-01', '2024-10-31', 'activo', 'presencial', NULL, 35, 5, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(11, 'Economía Internacional', 'Análisis de las relaciones económicas globales', '2024-05-20', '2024-10-15', 'finalizado', 'hibrido', 'https://meet.google.com/economia-internacional', 25, 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(12, 'Medicina Preventiva', 'Fundamentos de medicina preventiva y salud pública', '2024-06-10', '2024-11-30', 'activo', 'virtual', 'https://zoom.us/j/medicina-preventiva', 20, 4, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(13, 'Derecho Constitucional', 'Estudio de la constitución y derechos fundamentales', '2024-07-01', '2024-12-15', 'activo', 'presencial', NULL, 30, 2, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(14, 'Tecnología Blockchain', 'Fundamentos y aplicaciones de la tecnología blockchain', '2024-06-20', '2024-11-30', 'activo', 'hibrido', 'https://meet.google.com/blockchain-tech', 25, 3, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(15, 'Sostenibilidad Ambiental', 'Principios de desarrollo sostenible y cuidado ambiental', '2024-07-15', '2024-12-31', 'activo', 'virtual', 'https://zoom.us/j/sostenibilidad', 35, 5, '2025-07-31 17:54:01', '2025-07-31 17:54:01');
CREATE TABLE `docentes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `especialidad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `docentes` (`id`, `nombre`, `apellido`, `dni`, `email`, `especialidad`, `telefono`, `direccion`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'Juan', 'Pérez', '12345678', 'juan.perez@gmail.com', 'Matemáticas', '011-1234-5678', 'Av. Corrientes 1234, CABA', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(2, 'María', 'García', '23456789', 'maria.garcia@gmail.com', 'Literatura', '011-2345-6789', 'Belgrano 567, CABA', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(3, 'Carlos', 'López', '34567890', 'carlos.lopez@gmail.com', 'Historia', '011-3456-7890', 'Palermo 890, CABA', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(4, 'Ana', 'Martínez', '45678901', 'ana.martinez@gmail.com', 'Ciencias', '011-4567-8901', 'Recoleta 123, CABA', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(5, 'Roberto', 'Silva', '56789012', 'roberto.silva@gmail.com', 'Inglés', '011-5678-9012', 'San Telmo 456, CABA', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01');
CREATE TABLE `evaluaciones` (
  `id` bigint UNSIGNED NOT NULL,
  `alumno_id` bigint UNSIGNED NOT NULL,
  `curso_id` bigint UNSIGNED NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nota` decimal(3,1) NOT NULL,
  `fecha` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `evaluaciones` (`id`, `alumno_id`, `curso_id`, `descripcion`, `nota`, `fecha`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Primer Parcial - Álgebra', 8.5, '2024-04-15', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(2, 1, 1, 'Segundo Parcial - Cálculo', 8.0, '2024-05-20', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(3, 2, 1, 'Primer Parcial - Álgebra', 7.8, '2024-04-15', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(4, 2, 1, 'Segundo Parcial - Cálculo', 7.5, '2024-05-20', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(5, 3, 1, 'Primer Parcial - Álgebra', 4.2, '2024-04-15', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(6, 4, 1, 'Primer Parcial - Álgebra', 9.1, '2024-04-15', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(7, 4, 1, 'Segundo Parcial - Cálculo', 9.0, '2024-05-20', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(8, 6, 2, 'Análisis Literario - Borges', 8.0, '2024-05-10', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(9, 7, 2, 'Análisis Literario - Borges', 7.5, '2024-05-10', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(10, 9, 2, 'Análisis Literario - Borges', 3.8, '2024-05-10', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(11, 10, 2, 'Análisis Literario - Borges', 8.8, '2024-05-10', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(12, 11, 3, 'Examen - Período Colonial', 7.9, '2024-06-15', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(13, 13, 3, 'Examen - Período Colonial', 8.2, '2024-06-15', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(14, 14, 3, 'Examen - Período Colonial', 4.5, '2024-06-15', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(15, 15, 3, 'Examen - Período Colonial', 7.6, '2024-06-15', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(16, 16, 4, 'Laboratorio - ADN', 9.2, '2024-06-20', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(17, 18, 4, 'Laboratorio - ADN', 8.7, '2024-06-20', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(18, 19, 4, 'Laboratorio - ADN', 3.9, '2024-06-20', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(19, 20, 4, 'Laboratorio - ADN', 7.8, '2024-06-20', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(20, 21, 5, 'Examen Oral - Conversación', 8.4, '2024-07-10', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(21, 23, 5, 'Examen Oral - Conversación', 7.9, '2024-07-10', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(22, 24, 5, 'Examen Oral - Conversación', 4.1, '2024-07-10', '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(23, 25, 5, 'Examen Oral - Conversación', 8.6, '2024-07-10', '2025-07-31 17:54:01', '2025-07-31 17:54:01');
CREATE TABLE `inscripciones` (
  `id` bigint UNSIGNED NOT NULL,
  `alumno_id` bigint UNSIGNED NOT NULL,
  `curso_id` bigint UNSIGNED NOT NULL,
  `fecha_inscripcion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('activo','aprobado','desaprobado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `nota_final` decimal(3,1) DEFAULT NULL,
  `asistencias` int NOT NULL DEFAULT '0',
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `evaluado_por_docente` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `inscripciones` (`id`, `alumno_id`, `curso_id`, `fecha_inscripcion`, `estado`, `nota_final`, `asistencias`, `observaciones`, `evaluado_por_docente`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-02-15 13:00:00', 'aprobado', 8.5, 18, 'Excelente rendimiento', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(2, 2, 1, '2024-02-16 14:00:00', 'aprobado', 7.8, 16, 'Buen trabajo', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(3, 3, 1, '2024-02-17 12:00:00', 'desaprobado', 4.2, 8, 'Baja asistencia', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(4, 4, 1, '2024-02-18 17:00:00', 'aprobado', 9.1, 19, 'Destacado', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(5, 5, 1, '2024-02-19 19:00:00', 'activo', NULL, 12, 'En curso', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(6, 6, 2, '2024-03-01 13:00:00', 'aprobado', 8.0, 17, 'Muy buen análisis', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(7, 7, 2, '2024-03-02 14:00:00', 'aprobado', 7.5, 15, 'Participación activa', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(8, 8, 2, '2024-03-03 12:00:00', 'activo', NULL, 10, 'En progreso', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(9, 9, 2, '2024-03-04 17:00:00', 'desaprobado', 3.8, 6, 'Falta de compromiso', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(10, 10, 2, '2024-03-05 19:00:00', 'aprobado', 8.8, 18, 'Excelente', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(11, 11, 3, '2024-03-20 13:00:00', 'aprobado', 7.9, 16, 'Buen trabajo', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(12, 12, 3, '2024-03-21 14:00:00', 'activo', NULL, 8, 'Cursando', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(13, 13, 3, '2024-03-22 12:00:00', 'aprobado', 8.2, 17, 'Muy participativo', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(14, 14, 3, '2024-03-23 17:00:00', 'desaprobado', 4.5, 7, 'Necesita mejorar', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(15, 15, 3, '2024-03-24 19:00:00', 'aprobado', 7.6, 15, 'Aprobado', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(16, 16, 4, '2024-03-05 13:00:00', 'aprobado', 9.2, 18, 'Excelente comprensión', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(17, 17, 4, '2024-03-06 14:00:00', 'activo', NULL, 12, 'En desarrollo', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(18, 18, 4, '2024-03-07 12:00:00', 'aprobado', 8.7, 17, 'Muy buen trabajo', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(19, 19, 4, '2024-03-08 17:00:00', 'desaprobado', 3.9, 5, 'Falta de estudio', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(20, 20, 4, '2024-03-09 19:00:00', 'aprobado', 7.8, 16, 'Aprobado', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(21, 21, 5, '2024-03-25 13:00:00', 'aprobado', 8.4, 18, 'Excelente pronunciación', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(22, 22, 5, '2024-03-26 14:00:00', 'activo', NULL, 14, 'Mejorando', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(23, 23, 5, '2024-03-27 12:00:00', 'aprobado', 7.9, 16, 'Buen progreso', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(24, 24, 5, '2024-03-28 17:00:00', 'desaprobado', 4.1, 6, 'Necesita más práctica', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(25, 25, 5, '2024-03-29 19:00:00', 'aprobado', 8.6, 17, 'Muy bien', 1, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(26, 26, 6, '2024-04-10 13:00:00', 'activo', NULL, 8, 'Comenzando', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(27, 27, 6, '2024-04-11 14:00:00', 'activo', NULL, 6, 'En progreso', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(28, 28, 7, '2024-05-05 13:00:00', 'activo', NULL, 4, 'Iniciando', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(29, 29, 7, '2024-05-06 14:00:00', 'activo', NULL, 3, 'Cursando', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(30, 30, 8, '2024-04-15 13:00:00', 'activo', NULL, 10, 'Buen progreso', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(31, 31, 8, '2024-04-16 14:00:00', 'activo', NULL, 8, 'En desarrollo', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(32, 32, 9, '2024-05-20 13:00:00', 'activo', NULL, 5, 'Comenzando', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(33, 33, 9, '2024-05-21 14:00:00', 'activo', NULL, 4, 'Iniciando', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(34, 34, 10, '2024-06-05 13:00:00', 'activo', NULL, 2, 'Recién iniciado', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(35, 35, 10, '2024-06-06 14:00:00', 'activo', NULL, 1, 'Comenzando', 0, '2025-07-31 17:54:01', '2025-07-31 17:54:01');
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1K2Xas4QiOskI48FBUQ5JDk9hh35sWb3vsb1TOL2', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMFNTVHR4N0s1bEFtZ2NoWDBsZWVJeVB3SUEydVp1WVdxNjZ3S0E3WiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1753987779);
CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` enum('admin','coordinador','docente') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'coordinador',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `rol`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'admin@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(2, 'Coordinador 1', 'coordinador1@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'coordinador', NULL, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(3, 'Coordinador 2', 'coordinador2@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'coordinador', NULL, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(4, 'Juan Pérez', 'juan.perez@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'docente', NULL, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(5, 'María García', 'maria.garcia@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'docente', NULL, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(6, 'Carlos López', 'carlos.lopez@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'docente', NULL, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(7, 'Ana Martínez', 'ana.martinez@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'docente', NULL, '2025-07-31 17:54:01', '2025-07-31 17:54:01'),
(8, 'Roberto Silva', 'roberto.silva@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'docente', NULL, '2025-07-31 17:54:01', '2025-07-31 17:54:01');
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_alumnos_email` (`email`),
  ADD KEY `idx_alumnos_dni` (`dni`),
  ADD KEY `idx_alumnos_activo` (`activo`);
ALTER TABLE `archivos_adjuntos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_archivos_curso` (`curso_id`);
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cursos_docente` (`docente_id`),
  ADD KEY `idx_cursos_estado` (`estado`),
  ADD KEY `idx_cursos_fecha` (`fecha_inicio`,`fecha_fin`);
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_docentes_email` (`email`),
  ADD KEY `idx_docentes_dni` (`dni`),
  ADD KEY `idx_docentes_activo` (`activo`);
ALTER TABLE `evaluaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_evaluaciones_alumno` (`alumno_id`),
  ADD KEY `idx_evaluaciones_curso` (`curso_id`);
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_inscripcion` (`alumno_id`,`curso_id`),
  ADD KEY `idx_inscripciones_alumno` (`alumno_id`),
  ADD KEY `idx_inscripciones_curso` (`curso_id`),
  ADD KEY `idx_inscripciones_estado` (`estado`);
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);
ALTER TABLE `alumnos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
ALTER TABLE `archivos_adjuntos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `cursos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
ALTER TABLE `docentes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `evaluaciones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
ALTER TABLE `inscripciones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
ALTER TABLE `archivos_adjuntos`
  ADD CONSTRAINT `archivos_adjuntos_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE;
ALTER TABLE `cursos`
  ADD CONSTRAINT `cursos_ibfk_1` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`) ON DELETE CASCADE;
ALTER TABLE `evaluaciones`
  ADD CONSTRAINT `evaluaciones_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluaciones_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE;
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE;
COMMIT;
