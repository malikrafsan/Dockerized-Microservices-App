package utils;

import java.io.IOException;
import java.io.InputStream;
import java.util.Properties;

public class PropertiesHandler {
    private Properties prop;

    public PropertiesHandler(String filename) {
        this.prop = new Properties();
        try (InputStream input = getClass().getClassLoader().getResourceAsStream(filename)) {
            this.prop.load(input);
        } catch (IOException ex) {
            ex.printStackTrace();
        }
    }

    public String get(String key) {
        return this.prop.getProperty(key);
    }
}
