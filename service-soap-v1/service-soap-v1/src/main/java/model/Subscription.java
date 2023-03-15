package model;

import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

import javax.xml.bind.annotation.*;
import java.sql.ResultSet;
import java.sql.SQLException;

@Getter
@Setter
@AllArgsConstructor
@NoArgsConstructor
@XmlRootElement
public class Subscription extends BaseModel {
    private Integer creatorId;
    private Integer subscriberId;
    private SubscriptionStatus status;

    @XmlEnum(String.class)
    public enum SubscriptionStatus {
        PENDING,
        ACCEPTED,
        REJECTED;

        public static SubscriptionStatus fromStatusCode(String value) {
            for (SubscriptionStatus status : SubscriptionStatus.values()) {
                if (status.toString().equalsIgnoreCase(value)) {
                    return status;
                }
            }
            return null;
        }
    }

    @Override
    public void constructFromSQL(ResultSet rs) throws SQLException {
        this.creatorId = rs.getInt("creator_id");
        this.subscriberId = rs.getInt("subscriber_id");
        this.status = Subscription.SubscriptionStatus.fromStatusCode(rs.getString("status"));
    }
}
