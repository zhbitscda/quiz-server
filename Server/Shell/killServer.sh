#!/bin/bash
ps -ef | grep "WorkerMan" | awk '{print $2}' | xargs kill -9