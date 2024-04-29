#!/bin/bash

# Función para enviar métrica a CloudWatch
send_metric_to_cloudwatch() {
    local metric_name=$1
    local value=$2
    aws cloudwatch put-metric-data --namespace "CustomMetrics" --metric-name "$metric_name" --value "$value"
}

# Verificar si el contenedor MySQL está corriendo
if docker ps -q --filter "name=mysql-db" | grep -q .; then
    # Enviar métrica igual a 0 si el contenedor está corriendo
    send_metric_to_cloudwatch "mysql" 0
else
    # Enviar métrica igual a 1 si el contenedor no está corriendo
    send_metric_to_cloudwatch "mysql" 1
fi

# Verificar si el contenedor PHP-webServer está corriendo
if docker ps -q --filter "name=PHP-webServer" | grep -q .; then
    # Enviar métrica igual a 0 si el contenedor está corriendo
    send_metric_to_cloudwatch "php-webserver" 0
else
    # Enviar métrica igual a 1 si el contenedor no está corriendo
    send_metric_to_cloudwatch "php-webserver" 1
fi

# Verificar si el contenedor phpmyadmin está corriendo
if docker ps -q --filter "name=phpmyadmin" | grep -q .; then
    # Enviar métrica igual a 0 si el contenedor está corriendo
    send_metric_to_cloudwatch "phpmyadmin" 0
else
    # Enviar métrica igual a 1 si el contenedor no está corriendo
    send_metric_to_cloudwatch "phpmyadmin" 1
fi

