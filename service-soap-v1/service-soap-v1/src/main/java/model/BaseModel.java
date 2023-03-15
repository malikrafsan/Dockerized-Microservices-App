package model;

public abstract class BaseModel {
    public abstract void constructFromSQL(java.sql.ResultSet rs) throws java.sql.SQLException;
}
