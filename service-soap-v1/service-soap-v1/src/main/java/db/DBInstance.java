package db;

import java.sql.Connection;

public interface DBInstance {
    public Connection getConnection();
}
