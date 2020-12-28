#!/usr/bin/env bash

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" <<-EOSQL
    CREATE USER task_user WITH PASSWORD 'task_password';
    CREATE DATABASE tasks;
    GRANT ALL PRIVILEGES ON DATABASE tasks TO task_user;
EOSQL

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "tasks" <<-EOSQL
    CREATE TABLE IF NOT EXISTS users (
      id UUID NOT NULL,
      username VARCHAR(250) NOT NULL,
      created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
      updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
      PRIMARY KEY(id)
    );

    CREATE TABLE IF NOT EXISTS tasks (
     id UUID NOT NULL,
     user_id UUID NOT NULL,
     name VARCHAR(250) NOT NULL,
     date date NOT NULL,
     done boolean DEFAULT FALSE,
     created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
     updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NOW(),
     PRIMARY KEY(id),
     CONSTRAINT fk_users
      FOREIGN KEY(user_id)
	      REFERENCES users(id)
	      ON DELETE CASCADE
    );

    CREATE INDEX ON users (id);

    CREATE INDEX ON tasks (id);
    CREATE INDEX ON tasks (user_id);
    CREATE INDEX ON tasks (date);

    GRANT ALL PRIVILEGES ON TABLE users TO task_user;
    GRANT ALL PRIVILEGES ON TABLE tasks TO task_user;

    INSERT INTO users VALUES ('8cdf1af4-a1ce-43f1-a082-a183d71fd685', 'user.one');
EOSQL