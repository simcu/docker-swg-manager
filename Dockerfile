FROM simcu/laravel
COPY . /home/
CMD sh /home/configByEnv.sh && /run.sh