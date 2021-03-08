SELECT 'CREATE DATABASE lbdb_db'
WHERE NOT EXISTS(SELECT FROM pg_database WHERE datname = 'lbdb_db');

CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

CREATE TABLE IF NOT EXISTS product
(
    id         uuid      DEFAULT uuid_generate_v4(),
    sku        integer      NOT NULL UNIQUE,
    title      VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS variant
(
    id    uuid DEFAULT uuid_generate_v4(),
    color VARCHAR(255) NOT NULL,
    size  VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);
