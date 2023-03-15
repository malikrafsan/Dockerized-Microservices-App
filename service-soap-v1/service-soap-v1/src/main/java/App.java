import utils.ConfigHandler;

import javax.xml.ws.Endpoint;

public class App {
    private final static String SERVER_HOST_KEY = "server.host";
    private final static String SERVER_PORT_KEY = "server.port";

    public static void main(String[] args) {
        try {
            ConfigHandler ch = ConfigHandler.getInstance();
            String host = ch.get(SERVER_HOST_KEY);
            String port = ch.get(SERVER_PORT_KEY);

            System.out.println("Starting server at " + host + ":" + port);
            Endpoint.publish(host+":"+port+"/ws/subscription", new ws.SubscriptionWSImpl());
            System.out.println("Server started at " + host + ":" + port);
        } catch (Exception e) {
            e.printStackTrace();
            System.out.println(e.getMessage());
        }
    }
}
