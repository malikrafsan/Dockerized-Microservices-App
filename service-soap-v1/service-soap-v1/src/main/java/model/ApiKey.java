package model;

import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

import java.sql.ResultSet;
import java.sql.SQLException;

@Getter
@Setter
@AllArgsConstructor
@NoArgsConstructor
public class ApiKey extends BaseModel {
    private String key;
    private String client;

    @Override
    public void constructFromSQL(ResultSet rs) throws SQLException {
        this.key = rs.getString("key");
        this.client = rs.getString("client");
    }
}
