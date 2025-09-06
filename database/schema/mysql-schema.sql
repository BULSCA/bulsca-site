/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` bigint unsigned DEFAULT NULL,
  `pinned` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `views` int NOT NULL DEFAULT '0',
  `thumbs_up` int NOT NULL DEFAULT '0',
  `thumbs_down` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `articles_author_foreign` (`author`),
  CONSTRAINT `articles_author_foreign` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `casualties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `casualties` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `manual_reference` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `casualties_group_foreign` (`group`),
  CONSTRAINT `casualties_group_foreign` FOREIGN KEY (`group`) REFERENCES `casualty_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `casualty_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `casualty_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `casualty_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `casualty_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `casualty_id` bigint unsigned NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `casualty_images_casualty_id_foreign` (`casualty_id`),
  CONSTRAINT `casualty_images_casualty_id_foreign` FOREIGN KEY (`casualty_id`) REFERENCES `casualties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `club_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uni` bigint unsigned NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `banner_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#070660',
  `banner_text_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#ffffff',
  PRIMARY KEY (`id`),
  KEY `club_pages_uni_foreign` (`uni`),
  CONSTRAINT `club_pages_uni_foreign` FOREIGN KEY (`uni`) REFERENCES `universities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `competition_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `competition_info` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `competition` bigint unsigned NOT NULL,
  `form_entry` text COLLATE utf8mb4_unicode_ci,
  `form_judges` text COLLATE utf8mb4_unicode_ci,
  `form_helpers` text COLLATE utf8mb4_unicode_ci,
  `timetable` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `general_location` text COLLATE utf8mb4_unicode_ci,
  `general_league_event` text COLLATE utf8mb4_unicode_ci,
  `general_required_kit` text COLLATE utf8mb4_unicode_ci,
  `general_fak_full` tinyint(1) DEFAULT NULL,
  `general_fak_travel` tinyint(1) DEFAULT NULL,
  `general_official_headref` text COLLATE utf8mb4_unicode_ci,
  `general_official_wetserc` text COLLATE utf8mb4_unicode_ci,
  `general_official_dryserc` text COLLATE utf8mb4_unicode_ci,
  `pool_location` text COLLATE utf8mb4_unicode_ci,
  `pool_length` decimal(8,2) DEFAULT NULL,
  `pool_lanes` int DEFAULT NULL,
  `pool_extra` text COLLATE utf8mb4_unicode_ci,
  `registration_location` text COLLATE utf8mb4_unicode_ci,
  `registration_extra` text COLLATE utf8mb4_unicode_ci,
  `teams_cost` decimal(9,2) NOT NULL DEFAULT '0.00',
  `teams_limit` int NOT NULL DEFAULT '0',
  `teams_extra` text COLLATE utf8mb4_unicode_ci,
  `food_cost` decimal(9,2) NOT NULL DEFAULT '0.00',
  `food_options` text COLLATE utf8mb4_unicode_ci,
  `social_location` text COLLATE utf8mb4_unicode_ci,
  `social_cost` decimal(9,2) NOT NULL DEFAULT '0.00',
  `social_theme` text COLLATE utf8mb4_unicode_ci,
  `accom_location` text COLLATE utf8mb4_unicode_ci,
  `accom_cost` decimal(9,2) NOT NULL DEFAULT '0.00',
  `accom_extra` text COLLATE utf8mb4_unicode_ci,
  `contact_organiser_name` text COLLATE utf8mb4_unicode_ci,
  `contact_organiser_email` text COLLATE utf8mb4_unicode_ci,
  `contact_organiser_phone` text COLLATE utf8mb4_unicode_ci,
  `contact_emergency_name` text COLLATE utf8mb4_unicode_ci,
  `contact_emergency_email` text COLLATE utf8mb4_unicode_ci,
  `contact_emergency_phone` text COLLATE utf8mb4_unicode_ci,
  `extra_info` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `competition_info_competition_foreign` (`competition`),
  CONSTRAINT `competition_info_competition_foreign` FOREIGN KEY (`competition`) REFERENCES `competitions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `competition_info_chk_1` CHECK (json_valid(`timetable`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `competition_uni_places`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `competition_uni_places` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `season_uni` bigint unsigned NOT NULL,
  `league_comp` bigint unsigned NOT NULL,
  `overal_pos` int NOT NULL,
  `a_pos` int DEFAULT NULL,
  `b_pos` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `competition_uni_places_season_uni_foreign` (`season_uni`),
  KEY `competition_uni_places_league_comp_foreign` (`league_comp`),
  CONSTRAINT `competition_uni_places_league_comp_foreign` FOREIGN KEY (`league_comp`) REFERENCES `competitions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `competition_uni_places_season_uni_foreign` FOREIGN KEY (`season_uni`) REFERENCES `season_unis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `competitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `competitions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `host` bigint unsigned DEFAULT NULL,
  `season` bigint unsigned DEFAULT NULL,
  `when` datetime NOT NULL,
  `results` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `short` varchar(420) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `results_resource` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'incomplete_setup',
  `pack_resource` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `results_type` enum('RESOURCE','LINK','NONE') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NONE',
  `results_link` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `competitions_host_foreign` (`host`),
  KEY `competitions_league_foreign` (`season`),
  KEY `competitions_results_resource_foreign` (`results_resource`),
  KEY `competitions_pack_resource_foreign` (`pack_resource`),
  CONSTRAINT `competitions_host_foreign` FOREIGN KEY (`host`) REFERENCES `universities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `competitions_league_foreign` FOREIGN KEY (`season`) REFERENCES `seasons` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `competitions_pack_resource_foreign` FOREIGN KEY (`pack_resource`) REFERENCES `resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `competitions_results_resource_foreign` FOREIGN KEY (`results_resource`) REFERENCES `resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `field_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `field_responses` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `form_field_id` int unsigned NOT NULL,
  `form_response_id` int unsigned NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `field_responses_form_field_id_foreign` (`form_field_id`),
  KEY `field_responses_form_response_id_foreign` (`form_response_id`),
  CONSTRAINT `field_responses_form_field_id_foreign` FOREIGN KEY (`form_field_id`) REFERENCES `form_fields` (`id`) ON DELETE CASCADE,
  CONSTRAINT `field_responses_form_response_id_foreign` FOREIGN KEY (`form_response_id`) REFERENCES `form_responses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `form_availabilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `form_availabilities` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int unsigned NOT NULL,
  `open_form_at` datetime DEFAULT NULL,
  `close_form_at` datetime DEFAULT NULL,
  `response_count_limit` int unsigned DEFAULT NULL,
  `available_weekday` tinyint unsigned DEFAULT NULL,
  `available_start_time` time DEFAULT NULL,
  `available_end_time` time DEFAULT NULL,
  `closed_form_message` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_availabilities_form_id_foreign` (`form_id`),
  CONSTRAINT `form_availabilities_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `form_collaborators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `form_collaborators` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_collaborators_form_id_foreign` (`form_id`),
  KEY `form_collaborators_user_id_foreign` (`user_id`),
  CONSTRAINT `form_collaborators_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `form_collaborators_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `form_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `form_fields` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int unsigned NOT NULL,
  `template` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `required` tinyint(1) DEFAULT NULL,
  `options` text COLLATE utf8mb4_unicode_ci,
  `filled` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_fields_form_id_foreign` (`form_id`),
  CONSTRAINT `form_fields_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `form_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `form_responses` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int unsigned NOT NULL,
  `response_code` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `respondent_ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `respondent_user_agent` varchar(511) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_responses_form_id_foreign` (`form_id`),
  CONSTRAINT `form_responses_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forms` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `forms_code_unique` (`code`),
  KEY `forms_user_id_foreign` (`user_id`),
  CONSTRAINT `forms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `global_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `global_notifications` (
  `title` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `league_places`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `league_places` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uni` bigint unsigned NOT NULL,
  `comp` bigint unsigned NOT NULL,
  `league` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pos` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `league_places_uni_foreign` (`uni`),
  KEY `league_places_comp_foreign` (`comp`),
  CONSTRAINT `league_places_comp_foreign` FOREIGN KEY (`comp`) REFERENCES `competitions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `league_places_uni_foreign` FOREIGN KEY (`uni`) REFERENCES `universities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `resource_page_section_resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resource_page_section_resources` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `section` bigint unsigned DEFAULT NULL,
  `resource` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordering` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `resource_page_section_resources_ordering_section_unique` (`ordering`,`section`),
  KEY `resource_page_section_resources_section_foreign` (`section`),
  KEY `resource_page_section_resources_resource_foreign` (`resource`),
  CONSTRAINT `resource_page_section_resources_resource_foreign` FOREIGN KEY (`resource`) REFERENCES `resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `resource_page_section_resources_section_foreign` FOREIGN KEY (`section`) REFERENCES `resource_page_sections` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `resource_page_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resource_page_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `page` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ordering` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `resource_page_sections_ordering_page_unique` (`ordering`,`page`),
  KEY `resource_page_sections_page_foreign` (`page`),
  CONSTRAINT `resource_page_sections_page_foreign` FOREIGN KEY (`page`) REFERENCES `resource_pages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `resource_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resource_pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` char(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `ordering` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `resource_pages_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resources` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `season_unis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `season_unis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `season` bigint unsigned DEFAULT NULL,
  `uni` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `season_unis_season_uni_unique` (`season`,`uni`),
  KEY `season_unis_uni_foreign` (`uni`),
  CONSTRAINT `season_unis_season_foreign` FOREIGN KEY (`season`) REFERENCES `seasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `season_unis_uni_foreign` FOREIGN KEY (`uni`) REFERENCES `universities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `seasons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `seasons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `serc_resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `serc_resources` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `serc_id` bigint unsigned NOT NULL,
  `resource_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `serc_resources_serc_id_foreign` (`serc_id`),
  KEY `serc_resources_resource_id_foreign` (`resource_id`),
  CONSTRAINT `serc_resources_resource_id_foreign` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `serc_resources_serc_id_foreign` FOREIGN KEY (`serc_id`) REFERENCES `sercs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `serc_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `serc_tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sercs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sercs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `when` date NOT NULL,
  `where` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `casualties` int DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tagged_casualties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tagged_casualties` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `casualty_id` bigint unsigned NOT NULL,
  `serc_tag_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tagged_casualties_casualty_id_foreign` (`casualty_id`),
  KEY `tagged_casualties_serc_tag_id_foreign` (`serc_tag_id`),
  CONSTRAINT `tagged_casualties_casualty_id_foreign` FOREIGN KEY (`casualty_id`) REFERENCES `casualties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tagged_casualties_serc_tag_id_foreign` FOREIGN KEY (`serc_tag_id`) REFERENCES `serc_tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tagged_sercs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tagged_sercs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `serc_id` bigint unsigned NOT NULL,
  `serc_tag_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tagged_sercs_serc_id_foreign` (`serc_id`),
  KEY `tagged_sercs_serc_tag_id_foreign` (`serc_tag_id`),
  CONSTRAINT `tagged_sercs_serc_id_foreign` FOREIGN KEY (`serc_id`) REFERENCES `sercs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tagged_sercs_serc_tag_id_foreign` FOREIGN KEY (`serc_tag_id`) REFERENCES `serc_tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telescope_monitoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `telescope_monitoring` (
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `universities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `universities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image_path` text COLLATE utf8mb4_unicode_ci,
  `location` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_universities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_universities` (
  `user` bigint unsigned NOT NULL,
  `uni` bigint unsigned NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `only_one_uni_per_user` (`user`),
  KEY `user_universities_uni_foreign` (`uni`),
  CONSTRAINT `user_universities_uni_foreign` FOREIGN KEY (`uni`) REFERENCES `universities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_universities_user_foreign` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'2014_10_12_100000_create_password_resets_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'2018_08_08_100000_create_telescope_entries_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2019_08_19_000000_create_failed_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2019_12_14_000001_create_personal_access_tokens_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2020_03_31_114745_remove_backpackuser_model',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2022_05_09_144754_create_league_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2022_05_09_145109_create_universities_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2022_05_09_145322_create_competitions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2022_05_09_153404_add_desc_to_comp',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2022_05_09_182120_change_league_to_season',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2022_05_09_190357_create_season_unis_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2022_05_11_163133_create_competition_uni_places_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2022_05_15_182637_create_club_pages_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2022_05_15_212040_club_profile_text_to_longtext',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2022_06_01_204537_create_resources_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2022_06_02_130657_add_results_id_to_competitions',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2022_07_05_134112_create_user_universities_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2022_07_07_115716_create_permission_tables',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2022_07_07_153256_add_status_to_competitions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2022_07_12_200313_create_competition_info_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2022_08_12_175106_create_dynamic_resource_section',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2022_08_14_103001_add_image_to_resource_pages',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2022_08_15_163931_add_image_to_universities_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2022_08_19_121811_create_articles_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2022_08_29_151635_add_content_to_resource_pages_section_resources',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2022_08_31_203101_add_ratings_to_articles',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2022_10_21_182739_update_articles_to_add_defaults',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2022_10_22_163710_remake_competition_info_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2022_11_14_170636_create_league_places_table',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2022_11_16_190001_add_comp_pack_to_competitions',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2022_11_16_192247_create_global_notifications_table',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2023_04_09_143405_update_competitions_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2023_04_20_190345_add_ordering_to_resource_pages_and_sections',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2023_04_21_125355_add_ordering_to_resource_page_section_resources_table',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2023_05_09_193225_update_competitions_table_to_allow_null_res_link',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2024_01_02_191331_update_competition_info_table_to_make_fak_nullable',12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2024_02_25_134719_add_location_to_unis',13);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2024_03_09_200643_add_colours_to_club_pages',14);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2024_06_30_160528_add_sercs_tables',15);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2024_07_01_150101_add_files_to_sercs',15);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42,'2024_07_01_173549_add_extra_fields_to_sercs_table',15);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (43,'2024_07_09_105916_add_views_to_sercs',16);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (44,'2024_08_05_154547_add_active_to_universities_table',17);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (45,'2024_08_05_171902_add_social_handles_to_universities_table',18);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (46,'2025_01_07_155627_add_category_to_serc_tags_table',19);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (47,'2025_01_09_153905_create_casualty_groups_table',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (48,'2025_01_09_153910_create_casualties_table',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (49,'2025_02_14_133705_create_casualty_images_table',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (50,'2025_02_14_152026_create_casualty_tags_table',20);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (51,'2018_12_10_200406_create_forms_table',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (52,'2018_12_10_200556_create_form_fields_table',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (53,'2018_12_10_200700_create_form_responses_table',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (54,'2018_12_11_130118_create_jobs_table',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (55,'2018_12_19_164049_modify_form_responses_table',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (56,'2018_12_19_171726_create_field_responses_table',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (57,'2018_12_31_105713_create_form_collaborators_table',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (58,'2019_03_24_201130_create_form_availabilities_table',21);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (59,'2025_09_05_231804_add_expires_at_to_personal_access_tokens_table',22);
