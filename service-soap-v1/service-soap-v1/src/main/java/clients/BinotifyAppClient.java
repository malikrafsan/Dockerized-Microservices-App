package clients;

import model.Subscription;
import utils.ConfigHandler;
import utils.HttpClientWrapper;

import java.util.HashMap;
import java.util.Map;

public class BinotifyAppClient {
    private static BinotifyAppClient instance;
    private String BINOTIFY_APP_URL;
    private final String BINOTIFY_APP_URL_KEY = "binotify_app.url";

    private BinotifyAppClient() {
        this.BINOTIFY_APP_URL = ConfigHandler.getInstance().get(BINOTIFY_APP_URL_KEY);
    }

    public static BinotifyAppClient getInstance() {
        if (instance == null) {
            instance = new BinotifyAppClient();
        }
        return instance;
    }

    public void testGet() {
        System.out.println(new HttpClientWrapper(this.BINOTIFY_APP_URL + "/api").get());
    }

    public void testPost() {
        Map<String, String> params = new HashMap<>();
        params.put("username", "John");
        params.put("password", "pass");
        System.out.println(new HttpClientWrapper(this.BINOTIFY_APP_URL + "/api").post(params));
    }

    public HttpClientWrapper.Result callback(Subscription model) {
        Map<String, String> params = new HashMap<>();
        params.put("creator_id", String.valueOf(model.getCreatorId()));
        params.put("subscriber_id", String.valueOf(model.getSubscriberId()));
        params.put("status", model.getStatus().toString());

        return new HttpClientWrapper(this.BINOTIFY_APP_URL + "/api/subscription/callback").post(params);
    }
}
