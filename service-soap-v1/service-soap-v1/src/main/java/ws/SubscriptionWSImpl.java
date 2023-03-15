package ws;

import clients.BinotifyAppClient;
import clients.BinotifyRestClient;
import lombok.var;
import model.Subscription;
import repository.SubscriptionRepo;
import utils.EmailUtil;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.mail.internet.AddressException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import java.util.stream.Collectors;

@WebService(endpointInterface = "ws.SubscriptionWS")
public class SubscriptionWSImpl extends BaseWS implements SubscriptionWS {
    @WebMethod
    public Subscription subscribe(int creator_id, int subscriber_id) {
        try {
            this.validateAndRecord(creator_id, subscriber_id);

            Subscription model = new Subscription(creator_id, subscriber_id, null);
            var result = SubscriptionRepo.getInstance().create(model);
            var emails = BinotifyRestClient.getInstance().getAdminEmails();
            Arrays.stream(emails).forEach(e -> {
                try {
                    System.out.println("Sending email to " + e);
                    EmailUtil.getInstance().send(e, "New Subscription Request",
                    "There is new subscription request from subscriber_id: "
                        + subscriber_id + " to creator_id: " + creator_id);
                    System.out.println("Successfully send email to " + e);
                } catch (AddressException ex) {
//                    throw new RuntimeException(ex);
                    System.out.println("Failed to send email to " + e);
                    ex.printStackTrace();
                }
            });

            return result;
        } catch (Exception e) {
            System.out.println("exception: " + e.getMessage());
            e.printStackTrace();
            return null;
        }
    }

    @WebMethod
    public Subscription acceptSubscription(int creator_id, int subscriber_id) {
        try {
            this.validateAndRecord(creator_id, subscriber_id);

            Subscription model = new Subscription(creator_id, subscriber_id, Subscription.SubscriptionStatus.ACCEPTED);
            var result = SubscriptionRepo.getInstance().update(model);
            var httpResult = BinotifyAppClient.getInstance().callback(result);
            System.out.println("http result: " + httpResult);

            return result;
        } catch (Exception e) {
            System.out.println("exception: " + e.getMessage());
            e.printStackTrace();
            return null;
        }
    }

    @WebMethod
    public Subscription rejectSubscription(int creator_id, int subscriber_id) {
        try {
            this.validateAndRecord(creator_id, subscriber_id);

            Subscription model = new Subscription(creator_id, subscriber_id, Subscription.SubscriptionStatus.REJECTED);
            var result = SubscriptionRepo.getInstance().update(model);
            BinotifyAppClient.getInstance().callback(result);

            return result;
        } catch (Exception e) {
            System.out.println("exception: " + e.getMessage());
            e.printStackTrace();
            return null;
        }
    }

    @WebMethod
    public List<Subscription> getSubscriptions() {
        try {
            this.validateAndRecord();
            return SubscriptionRepo.getInstance().findAll();
        } catch (Exception e) {
            System.out.println("exception: " + e.getMessage());
            e.printStackTrace();
            return null;
        }
    }

    @WebMethod
    public List<Subscription> checkStatus(String creatorIds, String subscriberIds) {
        try {
            this.validateAndRecord(creatorIds, subscriberIds);
            List<Integer> intCreatorIds = Arrays
                    .stream(creatorIds.split(","))
                    .map(Integer::parseInt)
                    .collect(Collectors.toList());
            List<Integer> intSubscriberIds = Arrays
                    .stream(subscriberIds.split(","))
                    .map(Integer::parseInt)
                    .collect(Collectors.toList());

            List<Subscription> result = new ArrayList<>();
            for (int i=0;i<intCreatorIds.size() && i < intSubscriberIds.size();i++) {
                result.add(SubscriptionRepo.getInstance().findById(
                        intCreatorIds.get(i), intSubscriberIds.get(i))
                );
            }

            return result.stream().filter(s -> s != null).collect(Collectors.toList());
        } catch (Exception e) {
            System.out.println("exception: " + e.getMessage());
            e.printStackTrace();
            return null;
        }
    }

    @WebMethod
    public List<Subscription> getByStatus(Subscription.SubscriptionStatus status) {
        try {
            this.validateAndRecord(status);
            return SubscriptionRepo.getInstance().findByStatus(status);
        } catch (Exception e) {
            System.out.println("exception: " + e.getMessage());
            e.printStackTrace();
            return null;
        }
    }
}
