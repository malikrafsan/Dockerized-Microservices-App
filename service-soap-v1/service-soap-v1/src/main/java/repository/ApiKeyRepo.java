package repository;

import db.DBInstance;
import db.DBInstanceImpl;
import model.ApiKey;
import model.Subscription;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;

public class ApiKeyRepo extends BaseRepo<ApiKey> {
    private static ApiKeyRepo instance;

    protected ApiKeyRepo(DBInstance db, String tableName) {
        super(db, tableName);
    }

    public static ApiKeyRepo getInstance() {
        if (instance == null) {
            instance = new ApiKeyRepo(
                DBInstanceImpl.getInstance(),
                "api_keys"
            );
        }
        return instance;
    }

    @Override
    public List<ApiKey> findAll() throws SQLException {
        List<ApiKey> result = new ArrayList<>();

        Statement stmt = this.db.getConnection().createStatement();
        ResultSet rs = stmt.executeQuery("SELECT * FROM " + this.tableName);
        while (rs.next()) {
            ApiKey subscription = new ApiKey();
            subscription.constructFromSQL(rs);
            result.add(subscription);
        }
        return result;
    }
}
