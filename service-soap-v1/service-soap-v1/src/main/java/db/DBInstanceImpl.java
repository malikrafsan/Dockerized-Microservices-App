package db;

import utils.ConfigHandler;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class DBInstanceImpl implements DBInstance {
    private static DBInstance instance = null;
    private Connection con;

    private final String DB_URL_KEY = "db.url";
    private final String DB_USER_KEY = "db.user";
    private final String DB_PASS_KEY = "db.pass";

    private DBInstanceImpl() {
        try {
            ConfigHandler ch = ConfigHandler.getInstance();
            String url = ch.get(DB_URL_KEY);
            String user = ch.get(DB_USER_KEY);
            String pass = ch.get(DB_PASS_KEY);
            System.out.println("Trying to connect to database at " + url + " with user " + user + " and pass " + pass);

            DriverManager.registerDriver(new com.mysql.cj.jdbc.Driver());
            this.con = DriverManager.getConnection(url, user, pass);
        } catch (SQLException ex) {
            System.out.println("SQLException: " + ex.getMessage());
            System.out.println("SQLState: " + ex.getSQLState());
            System.out.println("VendorError: " + ex.getErrorCode());
            ex.printStackTrace();
            System.exit(1);
        } catch (Exception e) {
            System.out.println(e.getMessage());
            e.printStackTrace();
            System.exit(1);
        }
    }

    @Override
    public Connection getConnection() {
        System.out.println("Connection: " + this.con);
        return this.con;
    }

    public static DBInstance getInstance() {
        if (instance == null) {
            instance = new DBInstanceImpl();
        }

        return instance;
    }

    protected void finalize () throws SQLException {
        this.con.close();
    }
}
