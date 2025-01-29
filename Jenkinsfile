pipeline {
    agent any

    environment {
        DOCKER_COMPOSE_FILE = 'docker-compose.yml'
    }

    stages {
        stage('Checkout') {
            steps {
                git branch:'main' url: 'https://github.com/Samarth-twid/Notes_App.git'
            }
        }
        stage('Build') {
            steps {
                script {
                    sh 'docker-compose -f $DOCKER_COMPOSE_FILE build'
                }
            }
        }
        stage('Test') {
            steps {
                script {
                    sh 'docker-compose -f $DOCKER_COMPOSE_FILE run app php artisan test'
                }
            }
        }
        stage('Deploy') {
            steps {
                script {
                    sh 'docker-compose -f $DOCKER_COMPOSE_FILE up -d'
                }
            }
        }
    }

    post {
        always {
            sh 'docker-compose -f $DOCKER_COMPOSE_FILE down'
        }
        success {
            echo 'Build and deployment successful!'
        }
        failure {
            echo 'Build failed!'
        }
    }
}
