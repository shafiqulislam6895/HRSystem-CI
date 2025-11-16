--
-- SQL Schema for New Features: Skill Gap & Training Recommender and Performance & Goal Gamification
--

-- --------------------------------------------------------
-- Feature 1: Skill Gap & Training Recommender
-- --------------------------------------------------------

-- Table structure for table `skills`
CREATE TABLE `skills` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `skill_name` VARCHAR(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `skill_name` (`skill_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table structure for table `designation_skills` (Required skills for a job role)
CREATE TABLE `designation_skills` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `des_id` INT(11) NOT NULL COMMENT 'Foreign key to designation table',
  `skill_id` INT(11) NOT NULL COMMENT 'Foreign key to skills table',
  `required_level` ENUM('Basic','Intermediate','Advanced','Expert') NOT NULL DEFAULT 'Intermediate',
  PRIMARY KEY (`id`),
  UNIQUE KEY `des_skill_unique` (`des_id`, `skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table structure for table `employee_skills` (Skills possessed by an employee)
CREATE TABLE `employee_skills` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `em_id` VARCHAR(64) NOT NULL COMMENT 'Foreign key to employee table (em_id)',
  `skill_id` INT(11) NOT NULL COMMENT 'Foreign key to skills table',
  `current_level` ENUM('Basic','Intermediate','Advanced','Expert') NOT NULL DEFAULT 'Basic',
  PRIMARY KEY (`id`),
  UNIQUE KEY `emp_skill_unique` (`em_id`, `skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table structure for table `training_courses`
CREATE TABLE `training_courses` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `course_name` VARCHAR(256) NOT NULL,
  `description` TEXT,
  `link` VARCHAR(512),
  `related_skill_id` INT(11) COMMENT 'Foreign key to skills table',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Feature 2: Performance & Goal Gamification
-- --------------------------------------------------------

-- Table structure for table `performance_points`
CREATE TABLE `performance_points` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `em_id` VARCHAR(64) NOT NULL COMMENT 'Foreign key to employee table (em_id)',
  `points` INT(11) NOT NULL DEFAULT 0,
  `reason` VARCHAR(256),
  `date_awarded` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `em_id_idx` (`em_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table structure for table `badges`
CREATE TABLE `badges` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `badge_name` VARCHAR(128) NOT NULL,
  `description` TEXT,
  `icon_class` VARCHAR(64) COMMENT 'Font Awesome class for icon',
  `point_threshold` INT(11) DEFAULT 0 COMMENT 'Points required to earn badge',
  PRIMARY KEY (`id`),
  UNIQUE KEY `badge_name` (`badge_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table structure for table `employee_badges`
CREATE TABLE `employee_badges` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `em_id` VARCHAR(64) NOT NULL COMMENT 'Foreign key to employee table (em_id)',
  `badge_id` INT(11) NOT NULL COMMENT 'Foreign key to badges table',
  `date_awarded` DATE NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `emp_badge_unique` (`em_id`, `badge_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Sample Data for Demonstration
-- --------------------------------------------------------

-- Sample Skills
INSERT INTO `skills` (`skill_name`) VALUES
('PHP'), ('CodeIgniter'), ('MySQL'), ('JavaScript'), ('SEO'), ('Content Marketing'),
('Social Media'), ('Analytics'), ('Recruitment'), ('Labor Law'), ('HR Software');

-- Sample Designation Skills (for Software Engineer - des_id 15)
-- Assuming 'Software Engineer' is des_id 15 based on the dump
INSERT INTO `designation_skills` (`des_id`, `skill_id`, `required_level`) VALUES
(15, (SELECT id FROM skills WHERE skill_name = 'PHP'), 'Advanced'),
(15, (SELECT id FROM skills WHERE skill_name = 'CodeIgniter'), 'Advanced'),
(15, (SELECT id FROM skills WHERE skill_name = 'MySQL'), 'Intermediate'),
(15, (SELECT id FROM skills WHERE skill_name = 'JavaScript'), 'Intermediate');

-- Sample Employee Skills (for Doe1753 - an employee)
INSERT INTO `employee_skills` (`em_id`, `skill_id`, `current_level`) VALUES
('Doe1753', (SELECT id FROM skills WHERE skill_name = 'PHP'), 'Intermediate'),
('Doe1753', (SELECT id FROM skills WHERE skill_name = 'MySQL'), 'Intermediate'),
('Doe1753', (SELECT id FROM skills WHERE skill_name = 'JavaScript'), 'Basic');

-- Sample Training Courses
INSERT INTO `training_courses` (`course_name`, `description`, `link`, `related_skill_id`) VALUES
('Advanced CodeIgniter Development', 'Master the latest features of CodeIgniter.', '#', (SELECT id FROM skills WHERE skill_name = 'CodeIgniter')),
('Modern JavaScript Frameworks', 'Learn React, Vue, or Angular.', '#', (SELECT id FROM skills WHERE skill_name = 'JavaScript')),
('Search Engine Optimization Masterclass', 'Comprehensive guide to modern SEO.', '#', (SELECT id FROM skills WHERE skill_name = 'SEO'));

-- Sample Badges
INSERT INTO `badges` (`badge_name`, `description`, `icon_class`, `point_threshold`) VALUES
('Bronze Performer', 'Achieved 500 performance points.', 'fa-medal', 500),
('Silver Performer', 'Achieved 1000 performance points.', 'fa-medal', 1000),
('Gold Performer', 'Achieved 2000 performance points.', 'fa-trophy', 2000),
('Team Player', 'Contributed significantly to a team project.', 'fa-users', 0);

-- Sample Performance Points
INSERT INTO `performance_points` (`em_id`, `points`, `reason`) VALUES
('Doe1753', 300, 'Completed Q1 Project Ahead of Schedule'),
('Doe1753', 200, 'Positive Customer Feedback'),
('Moo1402', 600, 'Exceeded Sales Target');

-- Sample Employee Badges
INSERT INTO `employee_badges` (`em_id`, `badge_id`, `date_awarded`) VALUES
('Doe1753', (SELECT id FROM badges WHERE badge_name = 'Bronze Performer'), CURDATE()),
('Moo1402', (SELECT id FROM badges WHERE badge_name = 'Bronze Performer'), CURDATE());
