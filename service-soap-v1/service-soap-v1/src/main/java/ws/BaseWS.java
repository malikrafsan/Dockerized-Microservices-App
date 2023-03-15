package ws;

import com.sun.net.httpserver.HttpExchange;
import lombok.var;
import model.ApiKey;
import model.Logging;
import repository.ApiKeyRepo;
import repository.LoggingRepo;

import javax.annotation.Resource;
import javax.xml.ws.WebServiceContext;
import javax.xml.ws.handler.MessageContext;
import java.sql.SQLException;
import java.util.Arrays;
import java.util.List;
import java.util.Map;
import java.sql.Timestamp;

public abstract class BaseWS {
    @Resource
    WebServiceContext context;
    private final String httpExchangeKey = "com.sun.xml.internal.ws.http.exchange";

    protected void recordClient(String endpoint, String description, String ipAddr) throws SQLException {
        System.out.println("Client " + ipAddr + " called " + endpoint + " with description: " + description);
        Timestamp ts = new Timestamp(System.currentTimeMillis());
        String s = ts.toString().split("\\.")[0];

        Logging model = new Logging(description, ipAddr, endpoint, s);
        Logging log = LoggingRepo.getInstance().create(model);
    }

    private String getRemoteAddr() {
        MessageContext mc = context.getMessageContext();
        HttpExchange httpExchange = (HttpExchange) mc.get(this.httpExchangeKey);
        System.out.println("remote addr: " + httpExchange.getRemoteAddress());

        return httpExchange.getRemoteAddress().toString().replace("/", "");
    }

    protected String getClientByApiKey() throws Exception {
        MessageContext mc = context.getMessageContext();
        Map<String, Object> requestHeader = (Map) mc.get(mc.HTTP_REQUEST_HEADERS);
        String apiKey = ((List<String>) requestHeader.get("api-key")).get(0);
        System.out.println("api key: " + apiKey);

        List<ApiKey> validApiKeys = ApiKeyRepo.getInstance().findAll();
        for (ApiKey validApiKey : validApiKeys) {
            if (validApiKey.getKey().equals(apiKey)) {
                return validApiKey.getClient();
            }
        }
        throw new Exception("Invalid API key");
    }

    protected void validateAndRecord(Object ...params) throws Exception {
        String client = this.getClientByApiKey();
        var ptrTrace = Thread.currentThread().getStackTrace()[2];
        String endpoint = ptrTrace.getClassName() + "." + ptrTrace.getMethodName();

        this.recordClient(endpoint, buildDesc(client, params), this.getRemoteAddr());
    }

    private String buildDesc(String client, Object ...params) {
        String paramsStr = Arrays.stream(params)
                .map(e -> "[" + e + "]")
                .reduce((a, b) -> a + "," + b)
                .orElse("");
        return client + ":parameters{" + paramsStr + "}";
    }
}
