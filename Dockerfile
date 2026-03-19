FROM php:8.3-cli

RUN apt-get update && apt-get install -y python3 python3-pip git curl patch \
    && rm -rf /var/lib/apt/lists/*

RUN pip3 install --break-system-packages pytest pytest-timeout

RUN git config --system --add safe.directory /app

WORKDIR /app

COPY . .
