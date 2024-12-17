
Real-time online quiz codding challenge
---

# Foreword
Handling an online quiz application with scores and leaderboard updated in real-time should not be a big dead if the number of active users is not too high. This is a simple implementation using some common web technologies and relational database. 
However, if the number of active users is high, calculating scores and updating leaderboard in real-time can be a big challenge since relational database takes time to process queries and update data. In this case, we may need to consider using NoSQL database or caching mechanism to handle the load.

## The Problem
### The system must meet the following requirements:

- Real-Time User Participation: Users should seamlessly join quiz sessions using a unique quiz ID, even when multiple participants join simultaneously.
- Real-Time Score Updates: As users submit their answers, their scores need to be calculated and reflected immediately.
- Dynamic Leaderboard: A real-time leaderboard must display participants’ scores and update promptly as scores change.
- Scalability and Performance: When the number of active users and records in the database increases significantly, calculating scores in a relational database becomes a major bottleneck. Performing score aggregation queries on large datasets can introduce latency, resulting in a poor user experience.

## The Solution
To address the problem, I have designed a scalable, performant, and maintainable system leveraging a combination of robust tools and technologies:

- Vue.js for an interactive and responsive frontend.
- Laravel as the backend framework to handle business logic and API development.
- RabbitMQ to enable real-time communication and decouple system components.
- MySQL for persistent storage of user and quiz data.
- Redis for real-time leaderboard management and caching.
- Pusher to broadcast real-time updates to the frontend using WebSocket connections.

Redis was chosen specifically to solve the score calculation and leaderboard performance problem. Unlike relational databases, Redis stores data in memory, making it extremely fast and lightweight. It provides a Sorted Set data structure, which is perfect for storing user scores and efficiently maintaining an ordered leaderboard. With Sorted Sets, retrieving the top scores and updating user rankings can be done in constant or logarithmic time, regardless of the number of records or active users.

To deliver real-time updates seamlessly to users, Pusher is used to broadcast messages directly to the frontend via WebSocket connections. This ensures that leaderboard updates, user scores, and quiz-related notifications are instantly displayed without requiring the client to repeatedly poll the server.

By combining Redis for efficient score management, Pusher for real-time broadcasting, and RabbitMQ for asynchronous processing, the system achieves high performance, low latency, and scalability. This ensures that users experience real-time interactions, from joining a quiz to viewing their scores and standings on a dynamic leaderboard.

This document will walk through the detailed system design, including the architecture, data flow, component breakdown, and implementation strategy.

# System Design

## Architecture Diagram

## Component Description

### Frontend (Vue.js)
The frontend is built using Vue.js, a popular JavaScript framework for building interactive web applications. Vue.js provides a reactive and component-based architecture that allows for easy integration with backend APIs and real-time data updates.
Vuejs will interact with the backend API to perform the following tasks:
- List all the quizzes available.
- Allow users to join a quiz session using a unique quiz ID.
- Display quiz questions and options.
- Submit user answers and receive real-time score updates.
- Show a dynamic leaderboard with user scores and rankings.

### Backend (Laravel)
The backend is developed using Laravel, a powerful PHP framework known for its elegant syntax and robust features. Laravel provides a rich set of tools for building RESTful APIs, handling business logic, and interacting with databases.

The backend API will be responsible for the following API endpoints:
- Fetching all available quizzes. `GET /api/quizzes`
- Allowing users to join a quiz session. `POST /api/quizzes/{quizId}/users`
- Fetching quiz questions and options. `GET /api/quizzes/{quizId}/questions`
- Submitting user answers and calculating scores. `POST /api/quizzes/{quizId}/questions/{questionId}/answers`
- Retrieving the leaderboard with user scores and rankings. `GET /api/quizzes/{quizId}/leaderboard`
- Create a new user. `POST /api/users`

### RabbitMQ
RabbitMQ is used to enable real-time communication between system components. It acts as a message broker that allows for asynchronous processing and decoupling of services. RabbitMQ will be used to handle the following tasks:
- Queueing user answers for score calculation.
- Broadcasting leaderboard updates to connected clients.

### MySQL
MySQL is used as the primary database for storing persistent data, such as user information, quiz details, questions, and answers. 

### Redis
Redis is used to manage real-time leaderboard updates and caching. It stores user scores in a Sorted Set data structure, allowing for efficient retrieval of top scores and rankings. Redis will be used for the following tasks:
- Storing user scores and updating rankings.
- Caching frequently accessed data to reduce database load.

### Pusher
Pusher is used to broadcast real-time updates to the frontend using WebSocket connections. It provides a seamless way to push messages to connected clients, ensuring that leaderboard updates, user scores, and quiz-related notifications are instantly displayed.

### Redis score update consumer
A separate service will consume messages from RabbitMQ and update user scores in Redis. This service will listen for score update events and perform the necessary calculations to update user scores and rankings in real-time. Whenever scores are updated, it will publish a message back to RabbitMQ to notify about leaderboard changes.

### Leaderboard consumer
Another service will consume messages from RabbitMQ and broadcast leaderboard updates to connected clients using Pusher. This service will listen for leaderboard update events and push messages to Pusher then Pusher will broadcast the updates to all connected clients.

### Mysql score update consumer
A separate service will consume messages from RabbitMQ and update user scores in MySQL.

# Data Flow
When a user joins a quiz session, the following data flow occurs:

### User Registration and Quiz Participation
- When a user navigates to the quiz details page, the frontend will check if there is a user session available. If not, it will prompt the user to create a new user.
- The user will provide their name and other details to create a new user. The frontend will send a request to the backend API to create a new user.
- Once the user is created, the frontend will display the quiz questions and options for each question by calling the backend API to fetch quiz details.
- The frontend will call the backend API to let user join the quiz session using a unique quiz ID.

### Quiz Participation and Score Calculation
- As the user submits answers to quiz questions, the frontend will send the answers to the backend API for scoring.
- Backend API will check the correctness of the answers and calculate the user's score based on the quiz rules then return the result to the frontend.
- The frontend will display the result of the question and the updated score to the user.
- At the same time, the backend API will publish a message to RabbitMQ to notify the score update.

### Real-Time Leaderboard updates
- The Redis score update consumer will consume the message, update the user's score in Redis, and publish a message back to RabbitMQ to notify the leaderboard consumer.
- The leaderboard consumer will consume the message, fetch the latest leaderboard data from Redis, and push the updates to Pusher.
- Pusher will broadcast the leaderboard updates to all connected clients in real-time.
- The frontend will receive the leaderboard updates and display the latest scores and rankings to the users.

# Implementation
## Database Schema

## Build For the Future
### Scalability
To handle a large number of active users and records, the system can be scaled horizontally by adding more instances of the backend API and message consumers. By distributing the load across multiple instances, the system can accommodate a higher number of concurrent users and maintain low latency.

### Performance
To improve performance further, the system can implement caching mechanisms at various levels. Redis can be used to cache frequently accessed data, such as quiz details, user scores, and leaderboard rankings. By caching data in memory, the system can reduce the number of database queries and improve response times. Additionally, a content delivery network (CDN) can be used to cache static assets and reduce latency for users accessing the frontend application. 
Optimizing database queries, indexing tables, and using database sharding can also help improve performance.

### Reliability
To ensure high availability and reliability, the system can implement fault-tolerant mechanisms such as load balancing, auto-scaling, and health checks. By monitoring system health and performance metrics, the system can automatically scale resources up or down based on demand. Implementing redundant components and fail-over mechanisms can also help prevent single points of failure and ensure continuous operation.

### Maintainability
To maintain the system effectively, the codebase should follow best practices and design patterns. Using a modular architecture, clean code, and automated testing can help reduce technical debt and improve code quality. Continuous integration and deployment (CI/CD) pipelines can automate the testing and deployment process, ensuring that changes are deployed safely and efficiently. Monitoring tools and logging mechanisms can provide insights into system performance and help diagnose issues quickly.
Unit tests, integration tests, and end-to-end tests should be implemented to ensure that the system functions correctly and reliably.

# Monitoring and Observability
To monitor the system's health and performance, various tools and techniques can be used:
- Logging: Implementing structured logging across system components can provide insights into application behavior, errors, and performance metrics. Tools like ELK Stack (Elasticsearch, Logstash, Kibana) can be used to aggregate and analyze logs.
- Metrics: Collecting and visualizing system metrics, such as response times, error rates, and resource utilization, can help identify performance bottlenecks and optimize system performance. Tools like Prometheus and Grafana can be used for monitoring.
- Tracing: Distributed tracing can help track requests across multiple services and identify latency issues. Tools like Jaeger and Zipkin can be used to trace requests and analyze performance.
- Alerting: Setting up alerts based on predefined thresholds can help detect anomalies and notify operators of potential issues. Tools like PagerDuty and OpsGenie can be used for alerting and incident management.
- Dashboards: Creating dashboards to visualize key metrics and system health can provide a quick overview of system performance. Tools like Grafana and Kibana can be used to build custom dashboards.


