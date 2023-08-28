FROM node:14

RUN npm i

EXPOSE 3000

CMD ["npm", "run", "watch"]