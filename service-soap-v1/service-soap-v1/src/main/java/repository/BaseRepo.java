package repository;

import db.DBInstance;

import java.sql.SQLException;
import java.util.List;
import java.util.Map;

public abstract class BaseRepo<Model> {
    protected DBInstance db;
    protected String tableName;

    protected BaseRepo(DBInstance db, String tableName) {
        this.db = db;
        this.tableName = tableName;
    }

    public List<Model> findAll() throws Exception {
        throw new Exception("Not implemented");
    }
    public Model create(Model model) throws Exception {
        throw new Exception("Not implemented");
    }
    public Model update(Model model) throws Exception {
        throw new Exception("Not implemented");
    }
    public Model delete(Model model) throws Exception {
        throw new Exception("Not implemented");
    }
}
