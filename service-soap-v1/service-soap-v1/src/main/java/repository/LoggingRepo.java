package repository;

import db.DBInstance;
import db.DBInstanceImpl;
import model.Logging;

import java.sql.SQLException;
import java.sql.Statement;

public class LoggingRepo extends BaseRepo<Logging> {
    private static LoggingRepo instance;

    protected LoggingRepo(DBInstance db, String tableName) {
        super(db, tableName);
    }

    public static LoggingRepo getInstance() {
        if (instance == null) {
            instance = new LoggingRepo(
                DBInstanceImpl.getInstance(),
                "logging"
            );
        }
        return instance;
    }

    @Override
    public Logging create(Logging log) throws SQLException {
        Statement stmt = this.db.getConnection().createStatement();
        int rs = stmt.executeUpdate("INSERT INTO " + this.tableName + " (description, IP, endpoint, requested_at) VALUES ('" + log.getDescription() + "', '" + log.getIP() + "', '" + log.getEndpoint() + "', '" + log.getRequested_at() + "')");
        if (rs > 0) {
            return log;
        }
        return null;
    }
}
