# FROM maven:3.8-openjdk-11
# # FROM openjdk:11-jre
#
# # Create app directory.
# WORKDIR /app
#
# # Copy the application files to the app directory.
# COPY . .
#
# # Install the application.
# # RUN mvn clean compile assembly:single
# # RUN mvn package
#
# # Expose the port
# EXPOSE 8001
#
# # Run the application.
# # CMD ["java", "-jar", "target/demo-1.0-jar-with-dependencies.jar"]
# ENTRYPOINT ["bash", "./scripts/init_server_dev.sh"]

FROM openjdk:8
COPY ./target /app
WORKDIR /app
EXPOSE 3003
ENTRYPOINT ["java", "-jar", "service_soap-jar-with-dependencies.jar"]
