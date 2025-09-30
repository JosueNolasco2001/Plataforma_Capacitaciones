-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-09-2025 a las 17:39:43
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
-- Base de datos: `plataforma_capacitaciones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1754422625),
('laravel_cache_356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1754422625;', 1754422625),
('laravel_cache_3ce05cc82cc1071fbabb9932f148cf25', 'i:1;', 1754084967),
('laravel_cache_3ce05cc82cc1071fbabb9932f148cf25:timer', 'i:1754084967;', 1754084967),
('laravel_cache_4ad6471d37612dbd67623ff55c91555e', 'i:1;', 1754687482),
('laravel_cache_4ad6471d37612dbd67623ff55c91555e:timer', 'i:1754687482;', 1754687482),
('laravel_cache_6a2223d039ad2c7d3bac0c13d3e15057', 'i:1;', 1754421596),
('laravel_cache_6a2223d039ad2c7d3bac0c13d3e15057:timer', 'i:1754421596;', 1754421596),
('laravel_cache_6f2d4bb6a36bfb77ded064d9891faa80', 'i:1;', 1754687099),
('laravel_cache_6f2d4bb6a36bfb77ded064d9891faa80:timer', 'i:1754687099;', 1754687099),
('laravel_cache_77de68daecd823babbb58edb1c8e14d7106e83bb', 'i:1;', 1754405124),
('laravel_cache_77de68daecd823babbb58edb1c8e14d7106e83bb:timer', 'i:1754405124;', 1754405124),
('laravel_cache_857b85a0861e2243e431cb7868d8c425', 'i:2;', 1757360202),
('laravel_cache_857b85a0861e2243e431cb7868d8c425:timer', 'i:1757360202;', 1757360202),
('laravel_cache_9a3c3603fde47df0265a37ba88ca997f', 'i:2;', 1754404930),
('laravel_cache_9a3c3603fde47df0265a37ba88ca997f:timer', 'i:1754404930;', 1754404930),
('laravel_cache_ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4', 'i:1;', 1754687138),
('laravel_cache_ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4:timer', 'i:1754687138;', 1754687138),
('laravel_cache_admin@example.com|127.0.0.1', 'i:1;', 1757359902),
('laravel_cache_admin@example.com|127.0.0.1:timer', 'i:1757359902;', 1757359902),
('laravel_cache_bee251cf9ad7229b490c32f1e1b2f260', 'i:2;', 1754084278),
('laravel_cache_bee251cf9ad7229b490c32f1e1b2f260:timer', 'i:1754084278;', 1754084278),
('laravel_cache_bichiponce16@gmail.com|10.1.5.29', 'i:1;', 1754687482),
('laravel_cache_bichiponce16@gmail.com|10.1.5.29:timer', 'i:1754687482;', 1754687482),
('laravel_cache_c82b685cc40dbd831c21273a6dde3a99', 'i:1;', 1756743572),
('laravel_cache_c82b685cc40dbd831c21273a6dde3a99:timer', 'i:1756743572;', 1756743572),
('laravel_cache_dc44958e29ffba8b810d21377ae366b5', 'i:1;', 1757359899),
('laravel_cache_dc44958e29ffba8b810d21377ae366b5:timer', 'i:1757359899;', 1757359899),
('laravel_cache_email-verification:1:timer', 'i:1754422022;', 1754422022),
('laravel_cache_email-verification:2', 'i:1;', 1754421635),
('laravel_cache_email-verification:2:timer', 'i:1754421635;', 1754421635),
('laravel_cache_email-verification:3:timer', 'i:1754405078;', 1754405078),
('laravel_cache_email-verification:5:timer', 'i:1754687101;', 1754687101),
('laravel_cache_testuser@gmail.com|10.1.5.252', 'i:2;', 1754404931),
('laravel_cache_testuser@gmail.com|10.1.5.252:timer', 'i:1754404931;', 1754404931),
('senacit_cache_857b85a0861e2243e431cb7868d8c425', 'i:2;', 1757360253),
('senacit_cache_857b85a0861e2243e431cb7868d8c425:timer', 'i:1757360253;', 1757360253),
('senacit_cache_ec4057c7396b3a50a79da18e2a52b2b0', 'i:1;', 1757432150),
('senacit_cache_ec4057c7396b3a50a79da18e2a52b2b0:timer', 'i:1757432150;', 1757432150);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` bigint(20) NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `video_id` bigint(20) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `usuario_id`, `video_id`, `contenido`, `fecha_creacion`) VALUES
(1, 1, 1, 'Holap', '2025-08-01 15:45:09'),
(2, 1, 2, 'Hola', '2025-08-01 21:37:26'),
(3, 3, 3, 'Que pedo raza', '2025-08-05 14:44:38'),
(4, 3, 1, 'Verdad que si', '2025-08-05 14:46:04'),
(5, 1, 3, 'tumbado dog', '2025-08-05 14:53:36'),
(6, 1, 3, 'npmbeeeeeeeeeeeee', '2025-08-05 14:54:52'),
(7, 3, 3, 'Jajajaja este man no vo', '2025-08-05 14:55:56'),
(8, 3, 3, 'Nahhh', '2025-08-05 14:56:08'),
(9, 1, 3, 'Hola', '2025-08-08 21:04:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` bigint(20) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `urlImg` varchar(512) NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `titulo`, `descripcion`, `urlImg`, `instructor_id`, `fecha_creacion`, `fecha_actualizacion`, `estado`) VALUES
(1, 'Curso de python', 'Cruso bonito de python', 'curso-de-python_1754062521.png', 1, '2025-08-01 21:35:23', '2025-08-01 21:35:23', 1),
(2, 'Cruso dos mi loco', 'Curso tumbado', 'cruso-dos-mi-loco_1754068829.png', 1, '2025-08-01 23:20:29', '2025-08-01 23:20:29', 0),
(3, 'Curso de python', 'curso 4 de python', 'curso-de-python_1754687543.png', 1, '2025-08-09 03:12:23', '2025-08-09 03:12:23', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diplomas`
--

CREATE TABLE `diplomas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `curso_id` bigint(20) NOT NULL,
  `codigo_diploma` varchar(100) NOT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `fecha_generacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_completado` date NOT NULL,
  `datos_curso` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Datos del curso al momento de generar el diploma' CHECK (json_valid(`datos_curso`)),
  `estado` enum('generado','descargado','revocado') DEFAULT 'generado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `diplomas`
--

INSERT INTO `diplomas` (`id`, `usuario_id`, `curso_id`, `codigo_diploma`, `ruta_archivo`, `nombre_archivo`, `fecha_generacion`, `fecha_completado`, `datos_curso`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'DIP-001-0001-20250908-01', 'diplomas/1/Diploma-Curso-de-python-Josue-David-Nolasco-Aguilera-DIP-001-0001-20250908-01.pdf', 'Diploma-Curso-de-python-Josue-David-Nolasco-Aguilera-DIP-001-0001-20250908-01.pdf', '2025-08-01 16:44:39', '2025-08-01', '{\"titulo\":\"Curso de python\",\"instructor_nombre\":\"Josue David Nolasco Aguilera\",\"descripcion\":\"Cruso bonito de python\",\"total_videos\":2,\"videos_completados\":2}', 'descargado', '2025-08-01 22:44:39', '2025-09-09 01:53:14'),
(2, 1, 2, 'DIP-002-0001-20250908', 'diplomas/1/Diploma-Cruso-dos-mi-loco-Josue-David-Nolasco-Aguilera-DIP-002-0001-20250908.pdf', 'Diploma-Cruso-dos-mi-loco-Josue-David-Nolasco-Aguilera-DIP-002-0001-20250908.pdf', '2025-08-01 17:21:29', '2025-08-01', '{\"titulo\":\"Cruso dos mi loco\",\"instructor_nombre\":\"Josue David Nolasco Aguilera\",\"descripcion\":\"Curso tumbado\",\"total_videos\":1,\"videos_completados\":1}', 'descargado', '2025-08-01 23:21:29', '2025-09-09 01:53:57'),
(3, 2, 2, 'DIP-002-0002-20250801-01', 'diplomas/2/Diploma-Cruso-dos-mi-loco-Carlos-Alberto-Nolasco-Aguiler-DIP-002-0002-20250801-01.pdf', 'Diploma-Cruso-dos-mi-loco-Carlos-Alberto-Nolasco-Aguiler-DIP-002-0002-20250801-01.pdf', '2025-08-01 17:23:03', '2025-08-01', '{\"titulo\":\"Cruso dos mi loco\",\"instructor_nombre\":\"Josue David Nolasco Aguilera\",\"descripcion\":\"Curso tumbado\",\"total_videos\":1,\"videos_completados\":1}', 'descargado', '2025-08-01 23:23:03', '2025-08-02 03:49:10'),
(4, 2, 1, 'DIP-001-0002-20250801-01', 'diplomas/2/Diploma-Curso-de-python-Carlos-Alberto-Nolasco-Aguiler-DIP-001-0002-20250801-01.pdf', 'Diploma-Curso-de-python-Carlos-Alberto-Nolasco-Aguiler-DIP-001-0002-20250801-01.pdf', '2025-08-01 21:28:06', '2025-08-01', '{\"titulo\":\"Curso de python\",\"instructor_nombre\":\"Josue David Nolasco Aguilera\",\"descripcion\":\"Cruso bonito de python\",\"total_videos\":2,\"videos_completados\":2}', 'generado', '2025-08-02 03:28:06', '2025-08-02 03:48:36'),
(6, 3, 2, 'DIP-002-0003-20250908', 'diplomas/3/Diploma-Cruso-dos-mi-loco-SANTOS-NOLASCO-GUIFARRO-DIP-002-0003-20250908.pdf', 'Diploma-Cruso-dos-mi-loco-SANTOS-NOLASCO-GUIFARRO-DIP-002-0003-20250908.pdf', '2025-08-05 14:45:03', '2025-08-05', '{\"titulo\":\"Cruso dos mi loco\",\"instructor_nombre\":\"Josue David Nolasco Aguilera\",\"descripcion\":\"Curso tumbado\",\"total_videos\":1,\"videos_completados\":1}', 'generado', '2025-08-05 20:45:03', '2025-09-09 01:56:31'),
(8, 1, 3, 'DIP-003-0001-20250908', 'diplomas/1/Diploma-Curso-de-python-Josue-David-Nolasco-Aguilera-DIP-003-0001-20250908.pdf', 'Diploma-Curso-de-python-Josue-David-Nolasco-Aguilera-DIP-003-0001-20250908.pdf', '2025-09-08 19:54:43', '2025-09-08', '{\"titulo\":\"Curso de python\",\"instructor_nombre\":\"Josue David Nolasco Aguilera\",\"descripcion\":\"curso 4 de python\",\"total_videos\":2,\"videos_completados\":2}', 'generado', '2025-09-09 01:54:43', '2025-09-09 01:54:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `curso_id` bigint(20) NOT NULL,
  `fecha_inscripcion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`usuario_id`, `curso_id`, `fecha_inscripcion`) VALUES
(1, 1, '2025-09-01 16:15:33'),
(1, 2, '2025-09-08 19:53:51'),
(1, 3, '2025-09-08 19:54:24'),
(3, 2, '2025-09-08 19:56:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `progreso`
--

CREATE TABLE `progreso` (
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `video_id` bigint(20) NOT NULL,
  `completado` tinyint(1) DEFAULT 0,
  `ultima_vista` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `progreso`
--

INSERT INTO `progreso` (`usuario_id`, `video_id`, `completado`, `ultima_vista`) VALUES
(1, 1, 1, '2025-09-01 16:23:13'),
(1, 2, 1, '2025-09-08 19:37:36'),
(1, 3, 1, '2025-08-08 20:56:36'),
(1, 4, 1, '2025-09-08 19:54:31'),
(1, 5, 1, '2025-09-08 19:54:37'),
(3, 3, 1, '2025-09-08 19:56:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` bigint(20) NOT NULL,
  `comentario_id` bigint(20) NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `contenido` text NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id`, `comentario_id`, `usuario_id`, `contenido`, `fecha_creacion`) VALUES
(1, 1, 1, 'Todo bien perrita', '2025-08-01 15:45:14'),
(2, 2, 1, 'Jfjfjd', '2025-08-04 21:49:27'),
(3, 2, 1, 'Hola', '2025-08-04 21:54:44'),
(4, 2, 1, 'Simkn', '2025-08-04 21:58:13'),
(5, 2, 1, 'Loco', '2025-08-04 22:02:28'),
(6, 1, 3, 'Jaajjaajbesye maje esta loco vos', '2025-08-05 14:45:54'),
(7, 4, 3, 'Mehhh', '2025-08-05 14:46:13'),
(8, 3, 1, 'que ondas', '2025-08-05 14:53:23'),
(9, 6, 1, 'va', '2025-08-05 14:55:06'),
(10, 7, 3, 'Verdad que si', '2025-08-05 14:56:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7f0lhHp6LO7pSDEElvJGixB5NW0dbrznkg0bjbkm', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRzIwWlBHYzZnbUloRHlBNFFVdVdGMFJNdzhiV25zZmRLa09UM2hTMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjM6Imh0dHBzOi8vbGFjYW1wYW5hLmxhYi9QbGF0YWZvcm1hX0NhcGFjaXRhY2lvbmVzL3B1YmxpYy9ob21lcGFnZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTIkQmZTbVAycEVkb2dNQThZci9YWnJQLkouNjZUdklLMHducmhQOWFZbEFjY2V5QnE0a25veGEiO30=', 1757360147),
('ATuop5jj9YuXFbuT5efkhAWhYa3syYetWw0XFERi', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZmhqem84Mk5zM24xOUxTWDdMZ3FtN2VMd1c2QkN0QTZ5aEdzaHY5MyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1757360176),
('eooFkZK08fsRjI3o7o0Wq92HdeOTq9ahh9pQAZOL', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibTVyVVc3SU0yeFpPdkRsbE10cEtzZVlCTXR3SWF6VDJoeDNYUm5jSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Njk6Imh0dHBzOi8vbGFjYW1wYW5hLmxhYi9QbGF0YWZvcm1hX0NhcGFjaXRhY2lvbmVzL3B1YmxpYy9jdXJzby8yL3ZpZGVvcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTIkS3lYdS44eEJPY25nVnhLdFNNNXJ0LmxmbWdUcnFiUzk1MFljd2UzZmxLZ1V1MExWT1Nld2UiO30=', 1757432217),
('Y1UcGAXoqOHcDl47u4QM7ApZQyLuyQRmfa4FbZIx', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRWN5ZEEzWHc0OHlwaDFCdklHSkpTVFdYeDJDVXlSdkpKUXV1aDZ1ZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTQ6Imh0dHBzOi8vbGFjYW1wYW5hLmxhYi9QbGF0YWZvcm1hX0NhcGFjaXRhY2lvbmVzL3B1YmxpYyI7fX0=', 1757362409);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Josue David Nolasco Aguilera', 'josuenolascoaguilera@gmail.com', 'user', '2025-08-06 01:36:05', '$2y$12$BfSmP2pEdogMA8Yr/XZrP.J.66TvIK0wnrhP9aYlAcceyBq4knoxa', NULL, NULL, NULL, 'BzcfyL0fRjChFvWKNGkw66QUHTJabC1x3wxcY2xG7YcbNqqtHdoxAhnnzLof', NULL, NULL, '2025-08-01 21:33:00', '2025-09-09 01:35:40'),
(2, 'Carlos Alberto Nolasco Aguilera', 'josuenolascoaguilera2@gmail.com', 'user', NULL, '$2y$12$yJgQfbo1.aVy9m0W2od/u.JwYixveIB.k85fEXClA.mlpzZXhXwj.', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-01 23:22:08', '2025-08-01 23:22:08'),
(3, 'SANTOS NOLASCO GUIFARRO', 'barcelona147jn@gmail.com', 'user', '2025-08-05 20:44:24', '$2y$12$KyXu.8xBOcngVxKtSM5rt.lfmgTrqbS950Ycwe3flKgUu0LVOSewe', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-05 20:42:49', '2025-08-05 20:44:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos`
--

CREATE TABLE `videos` (
  `id` bigint(20) NOT NULL,
  `curso_id` bigint(20) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `url` varchar(512) NOT NULL,
  `duracion` int(11) DEFAULT NULL COMMENT 'Duración en segundos',
  `orden` int(11) DEFAULT NULL COMMENT 'Orden dentro del curso',
  `estado` tinyint(1) DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `videos`
--

INSERT INTO `videos` (`id`, `curso_id`, `titulo`, `url`, `duracion`, `orden`, `estado`, `fecha_creacion`) VALUES
(1, 1, 'Introduccion a python', 'introduccion-a-python_1754062523.mp4', NULL, 1, 1, '2025-08-01 21:35:23'),
(2, 1, 'Arreglos en python', 'arreglos-en-python_1754062523.mp4', NULL, 2, 1, '2025-08-01 21:35:23'),
(3, 2, 'video pijudo', 'video-pijudo_1754068829.mp4', NULL, 1, 1, '2025-08-01 23:20:29'),
(4, 3, 'video 3', 'video-1_1754687543.mp4', NULL, 1, 1, '2025-08-09 03:12:23'),
(5, 3, 'video 2', 'video-2_1754687543.mp4', NULL, 2, 1, '2025-08-09 03:12:23');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`),
  ADD KEY `idx_usuario_id` (`usuario_id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_instructor_id` (`instructor_id`);

--
-- Indices de la tabla `diplomas`
--
ALTER TABLE `diplomas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_diploma` (`codigo_diploma`),
  ADD UNIQUE KEY `unique_usuario_curso` (`usuario_id`,`curso_id`),
  ADD KEY `idx_codigo_diploma` (`codigo_diploma`),
  ADD KEY `idx_usuario_curso` (`usuario_id`,`curso_id`),
  ADD KEY `diplomas_curso_id_foreign` (`curso_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`usuario_id`,`curso_id`),
  ADD UNIQUE KEY `unique_inscripcion` (`usuario_id`,`curso_id`),
  ADD KEY `curso_id` (`curso_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `progreso`
--
ALTER TABLE `progreso`
  ADD PRIMARY KEY (`usuario_id`,`video_id`),
  ADD UNIQUE KEY `unique_progreso` (`usuario_id`,`video_id`),
  ADD KEY `video_id` (`video_id`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comentario_id` (`comentario_id`),
  ADD KEY `idx_usuario_id` (`usuario_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_id` (`curso_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `diplomas`
--
ALTER TABLE `diplomas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `cursos_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `diplomas`
--
ALTER TABLE `diplomas`
  ADD CONSTRAINT `diplomas_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diplomas_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `progreso`
--
ALTER TABLE `progreso`
  ADD CONSTRAINT `progreso_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `progreso_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`comentario_id`) REFERENCES `comentarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respuestas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*----------------------------------------------------------------------SECOND DB-------------------------------------------------------------------------*/
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-09-2025 a las 17:41:18
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
-- Base de datos: `plataforma_capacitaciones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` bigint(20) NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `video_id` bigint(20) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` bigint(20) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `urlImg` varchar(512) NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diplomas`
--

CREATE TABLE `diplomas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `curso_id` bigint(20) NOT NULL,
  `codigo_diploma` varchar(100) NOT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `fecha_generacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_completado` date NOT NULL,
  `datos_curso` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Datos del curso al momento de generar el diploma' CHECK (json_valid(`datos_curso`)),
  `estado` enum('generado','descargado','revocado') DEFAULT 'generado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes`
--

CREATE TABLE `examenes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `curso_id` bigint(20) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `duracion_minutos` int(11) DEFAULT 30,
  `intentos_permitidos` int(11) DEFAULT 1,
  `porcentaje_aprobacion` int(11) DEFAULT 70,
  `estado` tinyint(1) DEFAULT 1,
  `orden` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `curso_id` bigint(20) NOT NULL,
  `fecha_inscripcion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones_respuesta`
--

CREATE TABLE `opciones_respuesta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pregunta_id` bigint(20) UNSIGNED NOT NULL,
  `opcion` text NOT NULL,
  `es_correcta` tinyint(1) DEFAULT 0,
  `orden` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `examen_id` bigint(20) UNSIGNED NOT NULL,
  `pregunta` text NOT NULL,
  `tipo` enum('multiple','verdadero_falso','texto') DEFAULT 'multiple',
  `puntos` int(11) DEFAULT 1,
  `orden` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `progreso`
--

CREATE TABLE `progreso` (
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `video_id` bigint(20) NOT NULL,
  `completado` tinyint(1) DEFAULT 0,
  `ultima_vista` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` bigint(20) NOT NULL,
  `comentario_id` bigint(20) NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `contenido` text NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas_usuario`
--

CREATE TABLE `respuestas_usuario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resultado_examen_id` bigint(20) UNSIGNED NOT NULL,
  `pregunta_id` bigint(20) UNSIGNED NOT NULL,
  `opcion_id` bigint(20) UNSIGNED DEFAULT NULL,
  `respuesta_texto` text DEFAULT NULL,
  `es_correcta` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_examenes`
--

CREATE TABLE `resultados_examenes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `examen_id` bigint(20) UNSIGNED NOT NULL,
  `calificacion` decimal(5,2) DEFAULT 0.00,
  `intento` int(11) DEFAULT 1,
  `completado` tinyint(1) DEFAULT 0,
  `tiempo_inicio` timestamp NULL DEFAULT NULL,
  `tiempo_fin` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos`
--

CREATE TABLE `videos` (
  `id` bigint(20) NOT NULL,
  `curso_id` bigint(20) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `url` varchar(512) NOT NULL,
  `duracion` int(11) DEFAULT NULL COMMENT 'Duración en segundos',
  `orden` int(11) DEFAULT NULL COMMENT 'Orden dentro del curso',
  `estado` tinyint(1) DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`),
  ADD KEY `idx_usuario_id` (`usuario_id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_instructor_id` (`instructor_id`);

--
-- Indices de la tabla `diplomas`
--
ALTER TABLE `diplomas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_diploma` (`codigo_diploma`),
  ADD UNIQUE KEY `unique_usuario_curso` (`usuario_id`,`curso_id`),
  ADD KEY `idx_codigo_diploma` (`codigo_diploma`),
  ADD KEY `idx_usuario_curso` (`usuario_id`,`curso_id`),
  ADD KEY `diplomas_curso_id_foreign` (`curso_id`);

--
-- Indices de la tabla `examenes`
--
ALTER TABLE `examenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_id` (`curso_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`usuario_id`,`curso_id`),
  ADD UNIQUE KEY `unique_inscripcion` (`usuario_id`,`curso_id`),
  ADD KEY `curso_id` (`curso_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `opciones_respuesta`
--
ALTER TABLE `opciones_respuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pregunta_id` (`pregunta_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `examen_id` (`examen_id`);

--
-- Indices de la tabla `progreso`
--
ALTER TABLE `progreso`
  ADD PRIMARY KEY (`usuario_id`,`video_id`),
  ADD UNIQUE KEY `unique_progreso` (`usuario_id`,`video_id`),
  ADD KEY `video_id` (`video_id`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comentario_id` (`comentario_id`),
  ADD KEY `idx_usuario_id` (`usuario_id`);

--
-- Indices de la tabla `respuestas_usuario`
--
ALTER TABLE `respuestas_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resultado_examen_id` (`resultado_examen_id`),
  ADD KEY `pregunta_id` (`pregunta_id`),
  ADD KEY `opcion_id` (`opcion_id`);

--
-- Indices de la tabla `resultados_examenes`
--
ALTER TABLE `resultados_examenes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_intento` (`usuario_id`,`examen_id`,`intento`),
  ADD KEY `examen_id` (`examen_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_id` (`curso_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `diplomas`
--
ALTER TABLE `diplomas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `examenes`
--
ALTER TABLE `examenes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `opciones_respuesta`
--
ALTER TABLE `opciones_respuesta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuestas_usuario`
--
ALTER TABLE `respuestas_usuario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `resultados_examenes`
--
ALTER TABLE `resultados_examenes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `cursos_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `diplomas`
--
ALTER TABLE `diplomas`
  ADD CONSTRAINT `diplomas_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `diplomas_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `examenes`
--
ALTER TABLE `examenes`
  ADD CONSTRAINT `examenes_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `opciones_respuesta`
--
ALTER TABLE `opciones_respuesta`
  ADD CONSTRAINT `opciones_respuesta_pregunta_id_foreign` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `fk_preguntas_examen` FOREIGN KEY (`examen_id`) REFERENCES `examenes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `progreso`
--
ALTER TABLE `progreso`
  ADD CONSTRAINT `progreso_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `progreso_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`comentario_id`) REFERENCES `comentarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respuestas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `respuestas_usuario`
--
ALTER TABLE `respuestas_usuario`
  ADD CONSTRAINT `respuestas_usuario_opcion_id_foreign` FOREIGN KEY (`opcion_id`) REFERENCES `opciones_respuesta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respuestas_usuario_pregunta_id_foreign` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respuestas_usuario_resultado_examen_id_foreign` FOREIGN KEY (`resultado_examen_id`) REFERENCES `resultados_examenes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `resultados_examenes`
--
ALTER TABLE `resultados_examenes`
  ADD CONSTRAINT `resultados_examenes_examen_id_foreign` FOREIGN KEY (`examen_id`) REFERENCES `examenes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resultados_examenes_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
