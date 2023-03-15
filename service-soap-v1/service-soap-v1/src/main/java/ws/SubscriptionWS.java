package ws;

import model.Subscription;

import javax.jws.WebMethod;
import javax.jws.WebService;
import java.util.List;

@WebService
public interface SubscriptionWS {
    @WebMethod
    public Subscription subscribe(int creator_id, int subscriber_id);

    @WebMethod
    public Subscription acceptSubscription(int creator_id, int subscriber_id);

    @WebMethod
    public Subscription rejectSubscription(int creator_id, int subscriber_id);

    @WebMethod
    public List<Subscription> getSubscriptions();

    @WebMethod
    public List<Subscription> checkStatus(String creatorIds, String subscriberIds);

    @WebMethod
    public List<Subscription> getByStatus(Subscription.SubscriptionStatus status);
}
