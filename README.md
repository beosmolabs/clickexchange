# ClickExchange
ClickExchange Website

## Installation

You will need to create a database

```bash
CREATE TABLE `link` (
  `id` int(11) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `type` enum('link','aff') NOT NULL,
  `date` text NOT NULL,
  `ip` text NOT NULL,
  `hide` enum('0','1','2') NOT NULL DEFAULT '0',
  `msg` text NOT NULL,
  `site` text NOT NULL,
  `secure` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL DEFAULT 0,
  `type` enum('admin','client','connexion','support','account','inscription','deconnexion') NOT NULL,
  `description` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `avatar` text NOT NULL,
  `rang` enum('0','1') NOT NULL DEFAULT '0',
  `last_date` text NOT NULL,
  `last_ip` text NOT NULL,
  `theme` enum('0','1') NOT NULL DEFAULT '0',
  `rocket` decimal(10,0) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


ALTER TABLE `link`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
```
