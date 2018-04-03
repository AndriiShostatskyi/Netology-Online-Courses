import requests
import argparse
import sys
import time
import json
import os

API_TOKEN = 'd13e692be69592b09fd22c77a590dd34e186e6\
d696daa88d6d981e1b4e296b14acb377e82dcbc81dc0f22'
URL = 'https://api.vk.com/method/'


class VKGroups:
    def __init__(self, api_token):
        self.token = api_token

    def myrequest(self, method, myparams):
        tries = 3
        s = requests.Session()
        while tries:
            try:
                r = s.get(URL + method, params=myparams, timeout=3)
                return r.json()['response']
            except requests.exceptions.Timeout:
                tries -= 1
                continue
        return []

    def get_groups(self, user_id):
        method = 'groups.get?'
        myparams = {
            'user_id': str(user_id),
            'access_token': self.token
        }
        return self.myrequest(method, myparams)

    def get_friends(self, user_id):
        method = 'friends.get?'
        myparams = {'user_id': str(user_id)}
        return self.myrequest(method, myparams)

    def get_unique_groups(self, user_id, n=0):
        print("Getting all friends of the user with id {0}".format(user_id))
        myfriends = self.get_friends(user_id)

        print("Getting all groups of the user with id {0}".format(user_id))
        mygroups = self.get_groups(user_id)

        groups_friend = []
        len_friends = len(myfriends)
        count = 0

        for friend in myfriends:
            groups_friend += self.get_groups(str(friend))
            count += 1
            print("Getting {0} friend's list of\
            groups out of {1} friends".format(count, len_friends), end="\r")
            time.sleep(0.35)

        print("\nFinding common groups out of {0}".format(len(groups_friend)))
        common_groups = list(
            set(mygroups) | (set(mygroups) & set(groups_friend)))
        users = set()
        len_groups = len(common_groups)
        method = 'groups.getMembers?'
        count = 1

        for group in common_groups:
            print("Checking {0} group \
            out of {1}".format(count, len_groups), end="\r")
            count += 1
            if int(n):
                myparams = {'group_id': str(group)}
                users = set(self.myrequest(method, myparams)['users'])
                users = users & set(myfriends)
                if len(users) > int(n):
                    pass
                else:
                    continue
            if group in groups_friend:
                common_groups.remove(group)
        print()
        return common_groups

    def save_unique_groups(self, user_id, n=0):
        unique_groups = self.get_unique_groups(user_id, n)
        result = []
        count = 0

        for group in unique_groups:
            method = 'groups.getById?'
            myparams = {
                'group_id': str(group),
                'access_token': self.token
            }
            r = self.myrequest(method, myparams)
            tmp = {
                'name': r[0]['name'],
                'gid': r[0]['gid']
            }

            method = 'groups.getMembers?'
            myparams = {'group_id': str(group)}
            r = self.myrequest(method, myparams)
            tmp['members_count'] = r['count']
            count += 1

            print("Saving {0} group out \
            of {1}".format(count, len(unique_groups)), end="\r")
            result.append(tmp)
            time.sleep(0.5)

        with open('groups.json', 'w', encoding='utf-8') as outfile:
            json.dump(result, outfile, ensure_ascii=False,
                      sort_keys=True, indent=4, separators=(',', ': '))

        print('\nUnique groups have been saved'
              ' in groups.json at {0}'.format(os.getcwd()))

# Ids for my testing:
# 18589824
# 260220399

if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument("id", type=int)
    parser.add_argument("n", type=int)
    args = parser.parse_args()
    vk = VKGroups(API_TOKEN)
    vk.save_unique_groups(args.id, args.n)
