CREATE TABLE IF NOT EXISTS `documentos` (
    `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre`      VARCHAR(255)     NOT NULL,
    `archivo`     VARCHAR(255)     NOT NULL,
    `descripcion` TEXT             NULL,
    `tipo`        VARCHAR(20)      NOT NULL DEFAULT 'pdf',
    `tamanio`     INT(11)          NOT NULL DEFAULT 0,
    `created_by`  VARCHAR(100)     NOT NULL DEFAULT 'sistema',
    `created_at`  DATETIME         NULL,
    `updated_at`  DATETIME         NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
