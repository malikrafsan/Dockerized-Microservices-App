package repository;

import db.DBInstance;
import db.DBInstanceImpl;
import model.Subscription;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;

public class SubscriptionRepo extends BaseRepo<Subscription> {
    private static SubscriptionRepo instance;

    protected SubscriptionRepo(DBInstance db, String tableName) {
        super(db, tableName);
    }

    public static SubscriptionRepo getInstance() {
        if (instance == null) {
            instance = new SubscriptionRepo(
                    DBInstanceImpl.getInstance(),
                    "subscriptions");
        }
        return instance;
    }

    @Override
    public List<Subscription> findAll() throws SQLException {
        List<Subscription> result = new ArrayList<>();

        Statement stmt = this.db.getConnection().createStatement();
        ResultSet rs = stmt.executeQuery("SELECT * FROM " + this.tableName);
        while (rs.next()) {
            Subscription subscription = new Subscription();
            subscription.constructFromSQL(rs);
            result.add(subscription);
        }
        return result;
    }

    public Subscription findById(int creatorId, int subscriberId) {
        try {
            Subscription result = new Subscription();

            Statement stmt = this.db.getConnection().createStatement();
            ResultSet rs = stmt.executeQuery("SELECT * FROM " + this.tableName + " WHERE creator_id = " + creatorId + " AND subscriber_id = " + subscriberId + " LIMIT 1");
            rs.next();
            result.constructFromSQL(rs);
            return result;
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }

    @Override
    public Subscription create(Subscription subscription) throws SQLException {
        Statement stmt = this.db.getConnection().createStatement();
        int rs = stmt.executeUpdate("INSERT INTO " + this.tableName + " (creator_id, subscriber_id) VALUES (" + subscription.getCreatorId() + ", " + subscription.getSubscriberId() + ")");
        if (rs > 0) {
            return this.findById(subscription.getCreatorId(), subscription.getSubscriberId());
        }
        return null;
    }

    @Override
    public Subscription update(Subscription subscription) throws SQLException {
        Statement stmt = this.db.getConnection().createStatement();
        int rs = stmt.executeUpdate("UPDATE " + this.tableName + " SET status = '"
                + subscription.getStatus().toString() + "' WHERE creator_id = "
                + subscription.getCreatorId() + " AND subscriber_id = "
                + subscription.getSubscriberId());
        if (rs > 0) {
            return this.findById(subscription.getCreatorId(), subscription.getSubscriberId());
        }
        return null;
    }

    @Override
    public Subscription delete(Subscription subscription) throws SQLException {
        Statement stmt = this.db.getConnection().createStatement();
        int rs = stmt.executeUpdate("DELETE FROM " + this.tableName + " WHERE creator_id = " + subscription.getCreatorId() + " AND subscriber_id = " + subscription.getSubscriberId());
        if (rs > 0) {
            return subscription;
        }
        return null;
    }

    public List<Subscription> findByStatus(Subscription.SubscriptionStatus status) throws SQLException {
        List<Subscription> result = new ArrayList<>();

        Statement stmt = this.db.getConnection().createStatement();
        ResultSet rs = stmt.executeQuery("SELECT * FROM " + this.tableName + " WHERE status = '" + status.toString() + "'");
        while (rs.next()) {
            Subscription subscription = new Subscription();
            subscription.constructFromSQL(rs);
            result.add(subscription);
        }
        return result;
    }
}
