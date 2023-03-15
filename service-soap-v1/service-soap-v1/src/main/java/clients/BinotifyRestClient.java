package clients;

import lombok.var;
import utils.ConfigHandler;
import utils.HttpClientWrapper;

public class BinotifyRestClient {
    private static BinotifyRestClient instance;
    private String BINOTIFY_REST_URL;
    private final String BINOTIFY_REST_URL_KEY = "binotify_rest.url";

    private BinotifyRestClient() {
        this.BINOTIFY_REST_URL = ConfigHandler.getInstance().get(BINOTIFY_REST_URL_KEY);
    }

    public static BinotifyRestClient getInstance() {
        if (instance == null) {
            instance = new BinotifyRestClient();
        }
        return instance;
    }

    public String[] getAdminEmails() {
        var res = new HttpClientWrapper(
                this.BINOTIFY_REST_URL + "/admin-emails").get();
        System.out.println(res);
        return res.getContent()
                .replace("\"","")
                .split(",");
    }
}
