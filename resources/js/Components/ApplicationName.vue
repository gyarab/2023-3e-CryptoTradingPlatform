<template>
  <div class="container">
    <p class="text">Cryptonest</p>
  </div>
</template>

<style>
/* https://www.youtube.com/watch?v=yefgBA1CecI */
.container {
  display: inline-block;
}

.text {
  position: relative;
  font-size: 3em;
  letter-spacing: 10px;
  font-family: monospace;
  border-right: 5px solid;
  width: 100%;
  white-space: nowrap;
  overflow: hidden;
  background-image: linear-gradient(to right, #3b82f6, #e740d6);
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: typing 2s steps(10) forwards, cursor .4s step-end infinite alternate;
}

.text::after {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  width: 5px;
  height: 100%;
  background-image: linear-gradient(to right, #3b82f6, #e740d6);
  animation: cursor .4s step-end infinite alternate;
}

@keyframes cursor {
  50% {
    background-color: transparent;
  }
}

@keyframes typing {
  from {
    width: 0;
  }
}
</style>
