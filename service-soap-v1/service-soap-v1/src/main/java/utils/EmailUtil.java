package utils;

import javax.mail.*;
import javax.mail.internet.AddressException;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;
import java.util.Date;
import java.util.Properties;

public class EmailUtil {
    private static EmailUtil instance;
    private Session session;
    private InternetAddress fromAddr;

    private final String MAIL_SMTP_HOST_KEY = "mail.smtp.host";
    private final String MAIL_SMTP_PORT_KEY = "mail.smtp.port";
    private final String MAIL_SMTP_SSL_ENABLE_KEY = "mail.smtp.ssl.enable";
    private final String MAIL_SMTP_AUTH_KEY = "mail.smtp.auth";
    private final String MAIL_SMTP_USERNAME_KEY = "mail.smtp.username";
    private final String MAIL_SMTP_PASSWORD_KEY = "mail.smtp.password";

    private EmailUtil() throws AddressException {
        ConfigHandler ch = ConfigHandler.getInstance();
        PropertiesHandler ph = ch.getPropertyHandler();
        this.session = Session.getInstance(
                this.buildProperties(ph), this.buildAuthenticator(ph));
        this.session.setDebug(true);
        this.fromAddr = new InternetAddress(ph.get(this.MAIL_SMTP_USERNAME_KEY));
    }

    private Properties buildProperties(PropertiesHandler ph) {
        Properties properties = System.getProperties();
        properties.put(MAIL_SMTP_HOST_KEY, ph.get(MAIL_SMTP_HOST_KEY));
        properties.put(MAIL_SMTP_PORT_KEY, ph.get(MAIL_SMTP_PORT_KEY));
        properties.put(MAIL_SMTP_SSL_ENABLE_KEY, ph.get(MAIL_SMTP_SSL_ENABLE_KEY));
        properties.put(MAIL_SMTP_AUTH_KEY, ph.get(MAIL_SMTP_AUTH_KEY));

        return properties;
    }

    private Authenticator buildAuthenticator(PropertiesHandler ph) {
        String fromEmail = ph.get(MAIL_SMTP_USERNAME_KEY);
        String password = ph.get(MAIL_SMTP_PASSWORD_KEY);

        return new Authenticator() {
            protected PasswordAuthentication getPasswordAuthentication() {
                return new PasswordAuthentication(fromEmail, password);
            }
        };
    }

    public static EmailUtil getInstance() throws AddressException {
        if (instance == null) {
            instance = new EmailUtil();
        }
        return instance;
    }

    public void send(String to, String subject, String body) {
        try {
            InternetAddress toAddr = new InternetAddress(to);

            MimeMessage message = new MimeMessage(session);
            message.setFrom(this.fromAddr);
            message.addRecipient(Message.RecipientType.TO, toAddr);
            message.setSubject(subject);
            message.setText(body);
            Transport.send(message);

            System.out.println(
                "Send email from " + this.fromAddr + " to " + toAddr + " at " + new Date());
        } catch (MessagingException mex) {
            mex.printStackTrace();
        }
    }

    public static void main(String[] args) throws AddressException {
        final String toEmail = "13520105@std.stei.itb.ac.id";
        EmailUtil.getInstance().send(toEmail,"TLSEmail Testing Subject", "TLSEmail Testing Body");
    }
}